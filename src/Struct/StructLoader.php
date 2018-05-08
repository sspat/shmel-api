<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;

class StructLoader
{
    /**
     * Тип выезда грузчиков: в переделах МКАД
     * @var int
     */
    const MKAD_INSIDE = 0;

    /**
     * Тип выезда грузчиков: за МКАД 20км-100км
     * @var int
     */
    const MKAD_FROM_20_TO_100 = 1;

    /**
     * Тип выезда грузчиков: за МКАД 100км-200км
     * @var int
     */
    const MKAD_FROM_100_TO_200 = 2;

    /**
     * Категория грузчика: сборщик/разборщик
     * @var string
     */
    const LOADER_TYPE_ASSEMBLER = '000000001';

    /**
     * Категория грузчика: только грузчик
     * @var string
     */
    const LOADER_TYPE_LIFTER = '000000002';

    /** @var \DateTimeImmutable */
    private $dateTime;

    /** @var string */
    private $idCategory;

    /** @var int */
    private $kmBeyondTheMkad;

    /** @var int */
    private $hours;

    /**
     * Время подачи грузчиков.
     *
     * @param \DateTimeImmutable $dateTime
     * @return StructLoader
     */
    public function setDateTime($dateTime)
    {
        Assert::isInstanceOf($dateTime, '\DateTimeImmutable');
        $this->dateTime = $dateTime;
        return $this;
    }

    /**
     * Категория грузчика. Доступные значения:
     * "000000001" – Сборщик/разборщик
     * "000000002" – Только грузчик
     *
     * @param string $idCategory
     * @return StructLoader
     */
    public function setIdCategory($idCategory)
    {
        Assert::oneOf(
            $idCategory,
            [
                self::LOADER_TYPE_ASSEMBLER,
                self::LOADER_TYPE_LIFTER
            ]
        );
        $this->idCategory = $idCategory;
        return $this;
    }

    /**
     * Тип выезда грузчиков.
     * 0 - В переделах МКАД
     * 1 - за МКАД 20км-100км
     * 2 – за МКАД 100км-200км
     *
     * @param int $kmBeyondTheMkad
     * @return StructLoader
     */
    public function setKmBeyondTheMkad($kmBeyondTheMkad)
    {
        Assert::oneOf(
            $kmBeyondTheMkad,
            [
                self::MKAD_INSIDE,
                self::MKAD_FROM_20_TO_100,
                self::MKAD_FROM_100_TO_200
            ]
        );
        $this->kmBeyondTheMkad = $kmBeyondTheMkad;
        return $this;
    }

    /**
     * Время работы в часах работы >=0
     *
     * @param int $hours
     * @return StructLoader
     */
    public function setHours($hours)
    {
        Assert::integer($hours);
        Assert::greaterThan($hours, 0);
        $this->hours = $hours;
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
            'kmBeyondTheMKAD' => $this->kmBeyondTheMkad,
            'Hours' => $this->hours
        ];
    }
}
