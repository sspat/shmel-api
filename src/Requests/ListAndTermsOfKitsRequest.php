<?php
namespace sspat\ShmelAPI\Requests;

final class ListAndTermsOfKitsRequest extends AbstractCacheableRequest
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
