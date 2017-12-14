<?php
namespace sspat\ShmelAPI\Requests;

final class CarsCategoriesRequest extends AbstractCacheableRequest
{
    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'CarsCategories';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\CarsCategoriesResponse';
    }
}
