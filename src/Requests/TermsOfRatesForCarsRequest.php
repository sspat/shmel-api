<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Exceptions\ShmelAPIConfigException;

final class TermsOfRatesForCarsRequest extends AbstractCacheableRequest
{
    /** @var string|null */
    private $id;

    /** @var string|null */
    private $rate;

    /** @var bool */
    private $relocation;

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

    /**
     * Выгружать только тарифы по переезду
     *
     * @param $relocation
     * @return self
     */
    public function setRelocation($relocation)
    {
        Assert::boolean($relocation);
        $this->relocation = $relocation;
        return $this;
    }

    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'TermsOfRatesForCars';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [
            [
                'StructRate' => [
                    'ID' => $this->id,
                    'Rate' => $this->rate,
                    'Relocation' => $this->relocation
                ]
            ]
        ];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\TermsOfRatesForCarsResponse';
    }
}
