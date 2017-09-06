<?php
namespace sspat\ShmelAPI\Requests;

class ListAndCostOfGoodsRequest extends AbstractCacheableRequest
{
    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'ListAndCostOfGoods';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\ListAndCostOfGoodsResponse';
    }
}
