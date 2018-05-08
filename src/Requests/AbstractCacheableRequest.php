<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Contracts\Request;

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
}
