<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Contracts\Request;
use sspat\ShmelAPI\Exceptions\ShmelAPIConfigException;

abstract class AbstractCacheableRequest implements Request
{
    /** @inheritdoc */
    public static function getCacheCategory()
    {
        return static::getMethodName();
    }

    /** @inheritdoc */
    public function getCacheId()
    {
        return md5(json_encode($this->getParameters()));
    }

    /**
     * @param string $parameter
     * @param mixed $value
     * @throws ShmelAPIConfigException
     */
    protected function ensureIsStringOrNull($parameter, $value)
    {
        if ($value !== null && !is_string($value)) {
            throw new ShmelAPIConfigException(
                'Invalid value for parameter '.$parameter. '. Value must be null or string.'
            );
        }
    }
}
