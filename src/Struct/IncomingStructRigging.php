<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Responses\TermsOfRatesForRiggingResponse;

class IncomingStructRigging
{
    /** @var \DateTimeImmutable */
    private $date;

    /** @var string */
    private $description;

    /** @var string */
    private $idRateConditionWeight;

    /** @var string */
    private $idRateConditionDistance;

    /**
     * Дата проведения работы.
     *
     * @param \DateTimeImmutable $date
     * @return IncomingStructRigging
     */
    public function setDate($date)
    {
        Assert::isInstanceOf($date, '\DateTimeImmutable');
        $this->date = $date;
        return $this;
    }

    /**
     * Описание такелажных работ. Максимум - 200 символов.
     *
     * @param string $description
     * @return IncomingStructRigging
     */
    public function setDescription($description)
    {
        Assert::stringNotEmpty($description);
        Assert::maxLength($description, 200);
        $this->description = $description;
        return $this;
    }

    /**
     * Значение поля ID функции TermsOfRigging (функция возвращает условия расчета такелажных работ)
     * с отбором равным 0 для поля RateCondition
     *
     * @param string $idRateConditionWeight
     * @return IncomingStructRigging
     *
     * @see TermsOfRatesForRiggingResponse
     */
    public function setIdRateConditionWeight($idRateConditionWeight)
    {
        Assert::stringNotEmpty($idRateConditionWeight);
        Assert::digits($idRateConditionWeight);
        $this->idRateConditionWeight = $idRateConditionWeight;
        return $this;
    }

    /**
     * Значение поля ID функции TermsOfRigging (функция возвращает условия расчета такелажных работ)
     * с отбором значения равным 1 для поля RateCondition
     *
     * @param string $idRateConditionDistance
     * @return IncomingStructRigging
     *
     * @see TermsOfRatesForRiggingResponse
     */
    public function setIdRateConditionDistance($idRateConditionDistance)
    {
        Assert::stringNotEmpty($idRateConditionDistance);
        Assert::digits($idRateConditionDistance);
        $this->idRateConditionDistance = $idRateConditionDistance;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Date' => $this->date->format('Y-m-d'),
            'Description' => $this->description,
            'IDRateConditionWeight' => $this->idRateConditionWeight,
            'IDRateConditionDistance' => $this->idRateConditionDistance
        ];
    }
}
