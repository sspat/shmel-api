<?php
namespace sspat\ShmelAPI\Struct;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Responses\ListAndTermsOfKitsResponse;

class IncomingStructOrderForRelocation
{
    /**
     * Тип переезда: Квартира
     * @var string
     */
    const RELOCATION_TYPE_APARTMENT = '000000001';

    /**
     * Тип переезда: Офис
     * @var string
     */
    const RELOCATION_TYPE_OFFICE = '000000002';

    /**
     * Физическое лицо
     * @var int
     */
    const PERSON_TYPE_PRIVATE = 0;

    /**
     * Юридическое лицо
     * @var int
     */
    const PERSON_TYPE_LEGAL = 1;

    /**
     * Вид оплаты: безналичная
     * @var int
     */
    const PAYMENT_TYPE_CASHLESS = 0;

    /**
     * Вид оплаты: наличная
     * @var int
     */
    const PAYMENT_TYPE_CASH = 1;

    /** @var string */
    private $typeOfRelocation;

    /** @var int */
    private $typeOfPerson;

    /** @var string */
    private $customer;

    /** @var string */
    private $phoneNumber;

    /** @var string */
    private $promoPhoneNumber;

    /** @var string */
    private $email;

    /** @var \DateTimeImmutable */
    private $date;

    /** @var int */
    private $paymentType;

    /** @var string */
    private $kit;

    /**
     * Тип переезда. Значения “000000001” – квартира, “000000002” - офис
     *
     * @param string $typeOfRelocation
     * @return IncomingStructOrderForRelocation
     */
    public function setTypeOfRelocation($typeOfRelocation)
    {
        Assert::oneOf(
            $typeOfRelocation,
            [
                self::RELOCATION_TYPE_APARTMENT,
                self::RELOCATION_TYPE_OFFICE
            ]
        );
        $this->typeOfRelocation = $typeOfRelocation;
        return $this;
    }

    /**
     * 0 – физическое лицо, 1 – юридическое лицо
     *
     * @param int $typeOfPerson
     * @return IncomingStructOrderForRelocation
     */
    public function setTypeOfPerson($typeOfPerson)
    {
        Assert::oneOf(
            $typeOfPerson,
            [
                self::PERSON_TYPE_PRIVATE,
                self::PERSON_TYPE_LEGAL
            ]
        );
        $this->typeOfPerson = $typeOfPerson;
        return $this;
    }

    /**
     * Имя заказчика. Максимум - 100 символов.
     *
     * @param string $customer
     * @return IncomingStructOrderForRelocation
     */
    public function setCustomer($customer)
    {
        Assert::stringNotEmpty($customer);
        Assert::maxLength($customer, 100);
        $this->customer = $customer;
        return $this;
    }

    /**
     * Телефон заказчика без кода страны. Пример: "9971002030"
     *
     * @param string $phoneNumber
     * @return IncomingStructOrderForRelocation
     */
    public function setPhoneNumber($phoneNumber)
    {
        Assert::stringNotEmpty($phoneNumber);
        Assert::regex($phoneNumber, '|\+\d+|');
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Промо телефон без кода страны. Пример: "9971002030"
     *
     * @param string $promoPhoneNumber
     * @return IncomingStructOrderForRelocation
     */
    public function setPromoPhoneNumber($promoPhoneNumber)
    {
        Assert::stringNotEmpty($promoPhoneNumber);
        Assert::regex($promoPhoneNumber, '|\+\d+|');
        $this->promoPhoneNumber = $promoPhoneNumber;
        return $this;
    }

    /**
     * Адрес электронной почты. Максимум - 100 символов.
     *
     * @param string $email
     * @return IncomingStructOrderForRelocation
     */
    public function setEmail($email)
    {
        Assert::stringNotEmpty($email);
        Assert::maxLength($email, 100);
        $this->email = $email;
        return $this;
    }

    /**
     * Дата заявки.
     *
     * @param \DateTimeImmutable $date
     * @return IncomingStructOrderForRelocation
     */
    public function setDate($date)
    {
        Assert::isInstanceOf($date, '\DateTimeImmutable');
        $this->date = $date;
        return $this;
    }

    /**
     * Вид оплаты. 0 –безналичная, 1 – наличная
     *
     * @param int $paymentType
     * @return IncomingStructOrderForRelocation
     */
    public function setPaymentType($paymentType)
    {
        Assert::oneOf(
            $paymentType,
            [
                self::PAYMENT_TYPE_CASHLESS,
                self::PAYMENT_TYPE_CASH
            ]
        );
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * Пакет услуг на переезд. ID из ListAndTermsOfKits
     *
     * @param string $kit
     * @return IncomingStructOrderForRelocation
     * @see ListAndTermsOfKitsResponse
     */
    public function setKit($kit)
    {
        Assert::stringNotEmpty($kit);
        Assert::digits($kit);
        $this->kit = $kit;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'TypeOfRelocation' => $this->typeOfRelocation,
            'TypeOfPerson' => $this->typeOfPerson,
            'Customer' => $this->customer,
            'PhoneNumber' => $this->phoneNumber,
            'PromoPhoneNumber' => $this->promoPhoneNumber,
            'Email' => $this->email,
            'Date' => $this->date->format('Y-m-d'),
            'PaymentType' => $this->paymentType,
            'Kit' => $this->kit
        ];
    }
}
