<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;

class IncomingStructAddress
{
    /**
     * Тип действия на адресе: Выгрузка
     * @var int
     */
    const ADDRESS_TYPE_UNLOAD = 0;

    /**
     * Тип действия на адресе: Загрузка
     * @var int
     */
    const ADDRESS_TYPE_LOAD = 1;

    /**
     * Наполненность помещения: Мало
     * @var string
     */
    const FILLING_LOW = 'Мало';

    /**
     * Наполненность помещения: Средне
     * @var string
     */
    const FILLING_MEDIUM = 'Средне';

    /**
     * Наполненность помещения: Много
     * @var string
     */
    const FILLING_HIGH = 'Много';

    /**
     * Класс помещения: Стандарт
     * @var string
     */
    const ROOM_CLASS_STANDARD = 'Стандарт';

    /**
     * Класс помещения: Евро
     * @var string
     */
    const ROOM_CLASS_EURO = 'Евро';

    /**
     * Класс помещения: VIP
     * @var string
     */
    const ROOM_CLASS_VIP = 'VIP';

    /** @var int */
    private $typeOfAddress;

    /** @var string */
    private $addressFieldCity;

    /** @var string */
    private $addressFieldStreet;

    /** @var string */
    private $addressFieldHome;

    /** @var string */
    private $addressFieldBlock;

    /** @var string */
    private $addressFieldApartment;

    /** @var string */
    private $filling;

    /** @var int */
    private $numberOfRooms;

    /** @var string */
    private $classOfRoom;

    /** @var string */
    private $contactPerson;

    /** @var string */
    private $phoneNumber;

    /** @var int */
    private $floor;

    /** @var bool */
    private $freightLift;

    /** @var bool */
    private $passengerLift;

    /** @var bool */
    private $assemblyDisassemblyOfFurniture;

    /** @var bool */
    private $garbageRemoval;

    /** @var bool */
    private $cleaning;

    /**
     * Тип действия на адресе. 0 – выгрузка, 1 – загрузка
     *
     * @param int $typeOfAddress
     * @return IncomingStructAddress
     */
    public function setTypeOfAddress($typeOfAddress)
    {
        Assert::oneOf(
            $typeOfAddress,
            [
                self::ADDRESS_TYPE_UNLOAD,
                self::ADDRESS_TYPE_LOAD
            ]
        );
        $this->typeOfAddress = $typeOfAddress;
        return $this;
    }

    /**
     * Город по КЛАДР. Не найденный город устанавливает как текстовая строка.
     *
     * @param string $addressFieldCity
     * @return IncomingStructAddress
     */
    public function setAddressFieldCity($addressFieldCity)
    {
        Assert::stringNotEmpty($addressFieldCity);
        $this->addressFieldCity = $addressFieldCity;
        return $this;
    }

    /**
     * Улица по КЛАДР. Не найденная улица устанавливает как текстовая строка.
     *
     * @param string $addressFieldStreet
     * @return IncomingStructAddress
     */
    public function setAddressFieldStreet($addressFieldStreet)
    {
        Assert::stringNotEmpty($addressFieldStreet);
        $this->addressFieldStreet = $addressFieldStreet;
        return $this;
    }

    /**
     * Номер дома
     *
     * @param string $addressFieldHome
     * @return IncomingStructAddress
     */
    public function setAddressFieldHome($addressFieldHome)
    {
        Assert::stringNotEmpty($addressFieldHome);
        $this->addressFieldHome = $addressFieldHome;
        return $this;
    }

    /**
     * Номер корпуса
     *
     * @param string $addressFieldBlock
     * @return IncomingStructAddress
     */
    public function setAddressFieldBlock($addressFieldBlock)
    {
        Assert::stringNotEmpty($addressFieldBlock);
        $this->addressFieldBlock = $addressFieldBlock;
        return $this;
    }

    /**
     * Номер квартиры
     *
     * @param string $addressFieldApartment
     * @return IncomingStructAddress
     */
    public function setAddressFieldApartment($addressFieldApartment)
    {
        Assert::stringNotEmpty($addressFieldApartment);
        $this->addressFieldApartment = $addressFieldApartment;
        return $this;
    }

    /**
     * Наполненность помещения. Доступные значения: "Мало", "Средне", "Много"
     *
     * @param string $filling
     * @return IncomingStructAddress
     */
    public function setFilling($filling)
    {
        Assert::oneOf(
            $filling,
            [
                self::FILLING_LOW,
                self::FILLING_MEDIUM,
                self::FILLING_HIGH
            ]
        );
        $this->filling = $filling;
        return $this;
    }

    /**
     * Количество комнат.
     *
     * @param int $numberOfRooms
     * @return IncomingStructAddress
     */
    public function setNumberOfRooms($numberOfRooms)
    {
        Assert::integer($numberOfRooms);
        Assert::greaterThan($numberOfRooms, 0);
        $this->numberOfRooms = $numberOfRooms;
        return $this;
    }

    /**
     * Класс помещения. Доступные значения: "Стандарт", "Евро", "VIP"
     *
     * @param string $classOfRoom
     * @return IncomingStructAddress
     */
    public function setClassOfRoom($classOfRoom)
    {
        Assert::oneOf(
            $classOfRoom,
            [
                self::ROOM_CLASS_STANDARD,
                self::ROOM_CLASS_EURO,
                self::ROOM_CLASS_VIP
            ]
        );
        $this->classOfRoom = $classOfRoom;
        return $this;
    }

    /**
     * Имя контактного лица на адресе. Максимум - 100 символов.
     *
     * @param string $contactPerson
     * @return IncomingStructAddress
     */
    public function setContactPerson($contactPerson)
    {
        Assert::stringNotEmpty($contactPerson);
        Assert::maxLength($contactPerson, 100);
        $this->contactPerson = $contactPerson;
        return $this;
    }

    /**
     * Телефон контрактного лица на адресе без кода страны. Пример: “9971002030”
     *
     * @param string $phoneNumber
     * @return IncomingStructAddress
     */
    public function setPhoneNumber($phoneNumber)
    {
        Assert::stringNotEmpty($phoneNumber);
        Assert::regex($phoneNumber, '|\+\d+|');
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Номер этажа
     *
     * @param int $floor
     * @return IncomingStructAddress
     */
    public function setFloor($floor)
    {
        Assert::integer($floor);
        $this->floor = $floor;
        return $this;
    }

    /**
     * Признак наличия грузового лифта
     *
     * @param bool $freightLift
     * @return IncomingStructAddress
     */
    public function setFreightLift($freightLift)
    {
        Assert::boolean($freightLift);
        $this->freightLift = $freightLift;
        return $this;
    }

    /**
     * Признак наличия пассажирского лифта
     *
     * @param bool $passengerLift
     * @return IncomingStructAddress
     */
    public function setPassengerLift($passengerLift)
    {
        Assert::boolean($passengerLift);
        $this->passengerLift = $passengerLift;
        return $this;
    }

    /**
     * Признак необходимости сборки/разборки мебели
     *
     * @param bool $assemblyDisassemblyOfFurniture
     * @return IncomingStructAddress
     */
    public function setAssemblyDisassemblyOfFurniture($assemblyDisassemblyOfFurniture)
    {
        Assert::boolean($assemblyDisassemblyOfFurniture);
        $this->assemblyDisassemblyOfFurniture = $assemblyDisassemblyOfFurniture;
        return $this;
    }

    /**
     * Признак необходимости уборки мусора
     *
     * @param bool $garbageRemoval
     * @return IncomingStructAddress
     */
    public function setGarbageRemoval($garbageRemoval)
    {
        Assert::boolean($garbageRemoval);
        $this->garbageRemoval = $garbageRemoval;
        return $this;
    }

    /**
     * Признак необходимости уборки помещения
     *
     * @param bool $cleaning
     * @return IncomingStructAddress
     */
    public function setCleaning($cleaning)
    {
        Assert::boolean($cleaning);
        $this->cleaning = $cleaning;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'TypeOfAddress' => $this->typeOfAddress,
            'AddressField2_City' => $this->addressFieldCity,
            'AddressField6_Street' => $this->addressFieldStreet,
            'AddressField7_Home' => $this->addressFieldHome,
            'AddressField8_Block' => $this->addressFieldBlock,
            'AddressField9_Apartment' => $this->addressFieldApartment,
            'Filling' => $this->filling,
            'NumberOfRooms' => $this->numberOfRooms,
            'ClassOfRoom' => $this->classOfRoom,
            'ContactPerson' => $this->contactPerson,
            'PhoneNumber' => $this->phoneNumber,
            'Floor' => $this->floor,
            'FreightLift' => $this->freightLift,
            'PassengerLift' => $this->passengerLift,
            'AssemblyDisassemblyOfFurniture' => $this->assemblyDisassemblyOfFurniture,
            'GarbageRemoval' => $this->garbageRemoval,
            'Cleaning' => $this->cleaning
        ];
    }
}
