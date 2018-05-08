<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Responses\ListAndCostOfServicesResponse;

class StructService
{
    /** @var \DateTimeImmutable */
    private $date;

    /** @var string */
    private $id;

    /** @var int */
    private $number;

    /**
     * Дата оказания услуги.
     *
     * @param \DateTimeImmutable $date
     * @return StructService
     */
    public function setDate($date)
    {
        Assert::isInstanceOf($date, '\DateTimeImmutable');
        $this->date = $date;
        return $this;
    }

    /**
     * Значение поля ID функции ListAndCostOfServices (функция возвращает доступный перечень услуг)
     *
     * @param string $id
     * @return StructService
     *
     * @see ListAndCostOfServicesResponse
     */
    public function setId($id)
    {
        Assert::stringNotEmpty($id);
        Assert::digits($id);
        $this->id = $id;
        return $this;
    }

    /**
     * Количество
     *
     * @param int $number
     * @return StructService
     */
    public function setNumber($number)
    {
        Assert::integer($number);
        Assert::greaterThan($number, 0);
        $this->number = $number;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Date' => $this->date->format('Y-m-d'),
            'ID' => $this->id,
            'Number' => $this->number
        ];
    }
}
