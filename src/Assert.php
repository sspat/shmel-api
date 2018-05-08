<?php
namespace sspat\ShmelAPI;

use sspat\ShmelAPI\Exceptions\ShmelAPIConfigException;

class Assert extends \Webmozart\Assert\Assert
{
    protected static function reportInvalidArgument($message)
    {
        throw new ShmelAPIConfigException($message);
    }
}
