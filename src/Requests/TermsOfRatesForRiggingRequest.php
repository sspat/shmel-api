<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Assert;

final class TermsOfRatesForRiggingRequest extends AbstractCacheableRequest
{
    /** @var string|null */
    private $id;

    /** @var string|null */
    private $rate;

    /**
     * Идентификатор (код) тарифного плана
     *
     * @param $id
     * @return self
     */
    public function setID($id)
    {
        Assert::nullOrString($id);
        $this->id = $id;
        return $this;
    }

    /**
     * Наименование тарифного плана
     *
     * @param $rate
     * @return self
     */
    public function setRate($rate)
    {
        Assert::nullOrString($rate);
        $this->rate = $rate;
        return $this;
    }

    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'TermsOfRatesForRigging';
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
        return 'sspat\ShmelAPI\Responses\TermsOfRatesForRiggingResponse';
    }
}
