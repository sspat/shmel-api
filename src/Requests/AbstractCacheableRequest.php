<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Contracts\Request;
use sspat\ShmelAPI\Exceptions\ShmelAPIException;

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
     * @throws ShmelAPIException
     */
    protected function ensureParameterIsStringOrNull($parameter, $value)
    {
        if (!is_null($value) && !is_string($value)) {
            throw new ShmelAPIException('Invalid value for paremeter '.$parameter. '. Value must be null or string.');
        }
    }
}
