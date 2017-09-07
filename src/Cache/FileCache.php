<?php
namespace sspat\ShmelAPI\Cache;

use sspat\ShmelAPI\Contracts\Cache;
use sspat\ShmelAPI\Exceptions\ShmelAPICacheException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

final class FileCache implements Cache
{
    /**
     * The default TTL for all caches is 24 hours
     */
    const DEFAULT_TTL = 86400;

    /** @var string */
    private $cacheDir;

    /** @var array|null */
    private $cacheTTLConfig;

    /**
     * FileCache constructor.
     * @param string $cacheDir
     * @param array|null $cacheTTLConfig
     * @throws ShmelAPICacheException
     */
    public function __construct($cacheDir, $cacheTTLConfig = null)
    {
        $this->setCacheDir($cacheDir);
        $this->setCacheTTLConfig($cacheTTLConfig);
    }

    /** @inheritdoc */
    public function getOrSet($category, $identifier, $function)
    {
        $cacheCategoryDir = $this->getCategoryDir($category);
        $cacheFilePath = $cacheCategoryDir.$identifier;
        $cacheEntryExists = is_file($cacheFilePath);
        $data = null;

        if ($cacheEntryExists && $this->isCacheEntryExpired($cacheFilePath, $category)) {
            $this->removeCacheEntry($cacheFilePath);
            $cacheEntryExists = false;
        }

        if ($cacheEntryExists) {
            $data = $this->getCacheEntryContents($cacheFilePath);
        } else {
            $data = $function();
            $this->createCacheEntry($data, $cacheFilePath);
        }

        return $data;
    }

    /** @inheritdoc */
    public function clearAll()
    {
        $this->recursiveRmDir($this->cacheDir);
    }

    /** @inheritdoc */
    public function clearCategory($category)
    {
        $this->recursiveRmDir($this->getCategoryDir($category));
    }

    /**
     * @param string $cacheDir
     * @throws ShmelAPICacheException
     */
    private function setCacheDir($cacheDir)
    {
        if (!is_dir($cacheDir)) {
            throw new ShmelAPICacheException('Cannot set cache directory. Directory '.$cacheDir.' does not exist.');
        }

        if (!is_writable($cacheDir)) {
            throw new ShmelAPICacheException('Cannot set cache directory. No write permission for '.$cacheDir);
        }

        $this->cacheDir = rtrim($cacheDir, DIRECTORY_SEPARATOR);
    }

    /**
     * @param array|null $cacheTTLConfig
     * @throws ShmelAPICacheException
     */
    private function setCacheTTLConfig($cacheTTLConfig)
    {
        if ($cacheTTLConfig === null) {
            return;
        }

        foreach ($cacheTTLConfig as $cacheCategory => $ttl) {
            if (filter_var($ttl, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
                throw new ShmelAPICacheException(
                    'Cache TTL for category '.$cacheCategory.' must be a positive integer'
                );
            }
            $this->cacheTTLConfig[$cacheCategory] = $ttl;
        }
    }

    /**
     * @param string $category
     * @return string
     */
    private function getCategoryDir($category)
    {
        return $this->cacheDir.DIRECTORY_SEPARATOR.$category.DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $category
     * @return int
     */
    private function getCategoryTTL($category)
    {
        return isset($this->cacheTTLConfig[$category]) ? $this->cacheTTLConfig[$category] : self::DEFAULT_TTL;
    }

    /**
     * @param string $cacheFilePath
     * @throws ShmelAPICacheException
     */
    private function removeCacheEntry($cacheFilePath)
    {
        if (@unlink($cacheFilePath) === false) {
            throw new ShmelAPICacheException('Error deleting expired cache entry: '.$cacheFilePath);
        }
    }

    /**
     * @param string $cacheFilePath
     * @param string $category
     * @return bool
     */
    private function isCacheEntryExpired($cacheFilePath, $category)
    {
        return filemtime($cacheFilePath) + $this->getCategoryTTL($category) < time();
    }

    /**
     * @param string $cacheFilePath
     * @return mixed
     * @throws ShmelAPICacheException
     */
    private function getCacheEntryContents($cacheFilePath)
    {
        $cacheEntryContents = @file_get_contents($cacheFilePath);
        if ($cacheEntryContents === false) {
            throw new ShmelAPICacheException('Error reading from cache entry: '.$cacheFilePath);
        }
        return unserialize($cacheEntryContents);
    }

    /**
     * @param mixed $data
     * @param string $cacheFilePath
     * @throws ShmelAPICacheException
     */
    private function createCacheEntry($data, $cacheFilePath)
    {
        $cacheCategoryDir = substr($cacheFilePath, 0, strrpos($cacheFilePath, DIRECTORY_SEPARATOR));

        if (!is_dir($cacheCategoryDir)) {
            if (!@mkdir($cacheCategoryDir, 0755, true) && !is_dir($cacheCategoryDir)) {
                throw new ShmelAPICacheException('Error creating cache category directory: '.$cacheCategoryDir);
            }
        }
        if (file_put_contents($cacheFilePath, serialize($data), LOCK_EX) === false) {
            throw new ShmelAPICacheException('Error creating cache entry: '.$cacheFilePath);
        }
    }

    /**
     * @param string $directory
     * @throws ShmelAPICacheException
     */
    private function recursiveRmDir($directory)
    {
        if (!is_dir($directory)) {
            throw new ShmelAPICacheException('Cannot delete unexisting directory '.$directory);
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $directory,
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $filename => $fileInfo) {
            if ($fileInfo->isDir()) {
                if (rmdir($filename) === false) {
                    throw new ShmelAPICacheException('Cannot deleting directory '.$filename);
                }
            } else {
                if (unlink($filename) === false) {
                    throw new ShmelAPICacheException('Cannot deleting file '.$filename);
                }
            }
        }
    }
}
