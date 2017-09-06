<?php
namespace sspat\ShmelAPI\Requests;

class TermsOfRiggingRequest extends AbstractCacheableRequest
{
    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'TermsOfRigging';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\TermsOfRiggingResponse';
    }
}
