<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Responses\ListAndCostOfGoodsResponse;

class StructGoods
{
    /** @var \DateTimeImmutable */
    private $date;

    /** @var string */
    private $id;

    /** @var int */
    private $number;

    /**
     * Дата доставки товара.
     *
     * @param \DateTimeImmutable $date
     * @return StructGoods
     */
    public function setDate($date)
    {
        Assert::isInstanceOf($date, '\DateTimeImmutable');
        $this->date = $date;
        return $this;
    }

    /**
     * Значение поля ID функции ListAndCostOfGoods (функция возвращает доступный перечень товаров)
     *
     * @param string $id
     * @return StructGoods
     *
     * @see ListAndCostOfGoodsResponse
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
     * @return StructGoods
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
