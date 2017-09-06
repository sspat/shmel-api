<?php
namespace sspat\ShmelAPI\Contracts;

use sspat\ShmelAPI\Exceptions\ShmelAPICacheException;

interface Cache
{
    /**
     * @param string $category
     * @param string $identifyer
     * @param callable $function
     * @return mixed
     * @throws ShmelAPICacheException
     */
    public function getOrSet($category, $identifyer, $function);

    /**
     * @return void
     * @throws ShmelAPICacheException
     */
    public function clearAll();

    /**
     * @param string $category
     * @return void
     * @throws ShmelAPICacheException
     */
    public function clearCategory($category);
}
