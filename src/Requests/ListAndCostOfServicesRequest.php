<?php
namespace sspat\ShmelAPI\Requests;

class ListAndCostOfServicesRequest extends AbstractCacheableRequest
{
    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'ListAndCostOfServices';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\ListAndCostOfServicesResponse';
    }
}
