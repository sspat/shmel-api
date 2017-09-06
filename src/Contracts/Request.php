<?php
namespace sspat\ShmelAPI\Contracts;

interface Request
{
    /**
     * @return string
     */
    public static function getMethodName();

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @return string
     */
    public static function getResponseFQCN();

    /**
     * @return string
     */
    public static function getCacheCategory();

    /**
     * @return string
     */
    public function getCacheId();
}
