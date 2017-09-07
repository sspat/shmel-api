<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Exceptions\ShmelAPIFacadeException;

final class TermsOfRatesForLoadersRequest extends AbstractCacheableRequest
{
    /** @var string|null */
    private $id;

    /** @var string|null */
    private $rate;

    /**
     * @param $id
     * @return self
     * @throws ShmelAPIFacadeException
     */
    public function setID($id)
    {
        $this->ensureParameterIsStringOrNull('ID', $id);
        $this->id = $id;
        return $this;
    }

    /**
     * @param $rate
     * @return self
     * @throws ShmelAPIFacadeException
     */
    public function setRate($rate)
    {
        $this->ensureParameterIsStringOrNull('Rate', $rate);
        $this->rate = $rate;
        return $this;
    }

    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'TermsOfRatesForLoaders';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [
            [
                'StructRate' => [
                    'ID' => $this->id,
                    'Rate' => $this->rate
                ]
            ]
        ];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\TermsOfRatesForLoadersResponse';
    }
}
