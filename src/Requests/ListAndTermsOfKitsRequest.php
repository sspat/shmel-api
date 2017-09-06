<?php
namespace sspat\ShmelAPI\Requests;

class ListAndTermsOfKitsRequest extends AbstractCacheableRequest
{
    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'ListAndTermsOfKits';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\ListAndTermsOfKitsResponse';
    }
}
