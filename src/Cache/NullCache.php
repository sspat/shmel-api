<?php
namespace sspat\ShmelAPI\Cache;

use sspat\ShmelAPI\Contracts\Cache;

final class NullCache implements Cache
{
    public function getOrSet($category, $identifier, $function)
    {
        return $function();
    }

    public function clearAll()
    {
    }

    public function clearCategory($category)
    {
    }
}
