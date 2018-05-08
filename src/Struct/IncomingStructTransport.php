<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Responses\TermsOfRatesForCarsResponse;

class IncomingStructTransport
{
    /** @var \DateTimeImmutable */
    private $dateTime;

    /** @var string */
    private $idCategory;

    /** @var int */
    private $additionalWorkTime;

    /** @var int */
    private $carMileageBeyondTheMkad;

    /**
     * Время подачи транспортного средства.
     *
     * @param \DateTimeImmutable $dateTime
     * @return IncomingStructTransport
     */
    public function setDateTime($dateTime)
    {
        Assert::isInstanceOf($dateTime, '\DateTimeImmutable');
        $this->dateTime = $dateTime;
        return $this;
    }

    /**
     * Значение поля ID из StructCathegory функции TermsOfRatesForCars
     * с параметром ID (Идентификатор (код) тарифного плана) – "000000026" или
     * с параметром Rate (Наименование тарифного плана) - "ФизическоеЛицоБезНДС".
     * Кроме значения "000000008"
     *
     * @param string $idCategory
     * @return IncomingStructTransport
     *
     * @see TermsOfRatesForCarsResponse
     */
    public function setIdCategory($idCategory)
    {
        Assert::stringNotEmpty($idCategory);
        Assert::digits($idCategory);
        Assert::notEq($idCategory, '000000008');
        $this->idCategory = $idCategory;
        return $this;
    }

    /**
     * Дополнительное время работы в часах работы >=0
     *
     * @param int $additionalWorkTime
     * @return IncomingStructTransport
     */
    public function setAdditionalWorkTime($additionalWorkTime)
    {
        Assert::integer($additionalWorkTime);
        Assert::greaterThan($additionalWorkTime, 0);
        $this->additionalWorkTime = $additionalWorkTime;
        return $this;
    }

    /**
     * Количество километров за МКАД >=0
     *
     * @param int $carMileageBeyondTheMkad
     * @return IncomingStructTransport
     */
    public function setCarMileageBeyondTheMkad($carMileageBeyondTheMkad)
    {
        Assert::integer($carMileageBeyondTheMkad);
        Assert::greaterThan($carMileageBeyondTheMkad, 0);
        $this->carMileageBeyondTheMkad = $carMileageBeyondTheMkad;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'DateTime' => $this->dateTime->format('Y-m-d\TH:i:\0\0\.\0\0\0'),
            'IDCategory' => $this->idCategory,
            'AdditionalWorkTime' => $this->additionalWorkTime,
            'CarMileageBeyondTheMKAD' => $this->carMileageBeyondTheMkad
        ];
    }
}
