<?php
namespace sspat\ShmelAPI\Requests;

use sspat\ShmelAPI\Assert;
use sspat\ShmelAPI\Struct\IncomingStructAddress;
use sspat\ShmelAPI\Struct\IncomingStructOrderForRelocation;
use sspat\ShmelAPI\Struct\IncomingStructRigging;
use sspat\ShmelAPI\Struct\IncomingStructTransport;
use sspat\ShmelAPI\Struct\StructGoods;
use sspat\ShmelAPI\Struct\StructLoader;
use sspat\ShmelAPI\Struct\StructService;

final class CreateOrderForRelocationRequest extends AbstractCacheableRequest
{
    /** @var IncomingStructOrderForRelocation */
    private $incomingStructOrderForRelocation;

    /** @var IncomingStructAddress[] */
    private $incomingStructAddresses = [];

    /** @var IncomingStructTransport[] */
    private $incomingStructTransports = [];

    /** @var StructLoader[] */
    private $structLoaders = [];

    /** @var IncomingStructRigging[] */
    private $incomingStructRigging = [];

    /** @var StructGoods[] */
    private $structGoods = [];

    /** @var StructService[] */
    private $structService = [];

    /**
     * CreateOrderForRelocationRequest constructor.
     * @param IncomingStructOrderForRelocation $incomingStructOrderForRelocation
     */
    public function __construct($incomingStructOrderForRelocation)
    {
        $this->setIncomingStructOrderForRelocation($incomingStructOrderForRelocation);
    }

    /**
     * Входящая структура с перечнем адресов переезда. Может не присутствовать.
     *
     * @param IncomingStructAddress $incomingStructAddress
     * @return self
     */
    public function addIncomingStructAddress($incomingStructAddress)
    {
        Assert::isInstanceOf(
            $incomingStructAddress,
            'sspat\ShmelAPI\Struct\IncomingStructAddress'
        );
        $this->incomingStructAddresses[] = $incomingStructAddress;
        return $this;
    }

    /**
     * Входящая структура с перечнем транспортных средств. Может не присутствовать.
     *
     * @param IncomingStructTransport $incomingStructTransport
     * @return self
     */
    public function addIncomingStructTransport($incomingStructTransport)
    {
        Assert::isInstanceOf(
            $incomingStructTransport,
            'sspat\ShmelAPI\Struct\IncomingStructTransport'
        );
        $this->incomingStructTransports[] = $incomingStructTransport;
        return $this;
    }

    /**
     * Входящая структура с перечнем грузчиков. Может не присутствовать.
     *
     * @param StructLoader $structLoader
     * @return self
     */
    public function addStructLoader($structLoader)
    {
        Assert::isInstanceOf(
            $structLoader,
            'sspat\ShmelAPI\Struct\StructLoader'
        );
        $this->structLoaders[] = $structLoader;
        return $this;
    }

    /**
     * Входящая структура с перечнем такелажных работ. Может не присутствовать.
     *
     * @param IncomingStructRigging $incomingStructRigging
     * @return self
     */
    public function addIncomingStructRigging($incomingStructRigging)
    {
        Assert::isInstanceOf(
            $incomingStructRigging,
            'sspat\ShmelAPI\Struct\IncomingStructRigging'
        );
        $this->incomingStructRigging[] = $incomingStructRigging;
        return $this;
    }

    /**
     * Входящая структура с перечнем товаров. Может не присутствовать.
     *
     * @param StructGoods $structGoods
     * @return self
     */
    public function addStructGoods($structGoods)
    {
        Assert::isInstanceOf(
            $structGoods,
            'sspat\ShmelAPI\Struct\StructGoods'
        );
        $this->structGoods[] = $structGoods;
        return $this;
    }

    /**
     * Входящая структура с перечнем дополнительных услуг. Может не присутствовать.
     *
     * @param StructService $structService
     * @return self
     */
    public function addStructService($structService)
    {
        Assert::isInstanceOf(
            $structService,
            'sspat\ShmelAPI\Struct\StructService'
        );
        $this->structService[] = $structService;
        return $this;
    }

    /** @inheritdoc */
    public static function getMethodName()
    {
        return 'CreateOrderForRelocation';
    }

    /** @inheritdoc */
    public function getParameters()
    {
        return [
            [
                'IncomingStructOrderForRelocation' => $this->incomingStructOrderForRelocation->toArray(),
                'IncomingStructAddresses' => array_map(
                    function ($incomingStructAddress) {
                        /** @var IncomingStructAddress $incomingStructAddress */
                        return $incomingStructAddress->toArray();
                    },
                    $this->incomingStructAddresses
                ),
                'IncomingStructTransport' => array_map(
                    function ($incomingStructTransport) {
                        /** @var IncomingStructTransport $incomingStructTransport */
                        return $incomingStructTransport->toArray();
                    },
                    $this->incomingStructTransports
                ),
                'StructLoaders' => array_map(
                    function ($structLoader) {
                        /** @var StructLoader $structLoader */
                        return $structLoader->toArray();
                    },
                    $this->structLoaders
                ),
                'IncomingStructRigging' => array_map(
                    function ($incomingStructRigging) {
                        /** @var IncomingStructRigging $incomingStructRigging */
                        return $incomingStructRigging->toArray();
                    },
                    $this->incomingStructRigging
                ),
                'StructGoods' => array_map(
                    function ($structGoods) {
                        /** @var StructGoods $structGoods */
                        return $structGoods->toArray();
                    },
                    $this->structGoods
                ),
                'StructService' => array_map(
                    function ($structService) {
                        /** @var StructService $structService */
                        return $structService->toArray();
                    },
                    $this->structService
                )
            ]
        ];
    }

    /** @inheritdoc */
    public static function getResponseFQCN()
    {
        return 'sspat\ShmelAPI\Responses\CreateOrderForRelocationResponse';
    }

    /**
     * Параметры шапки документа
     *
     * @param IncomingStructOrderForRelocation $incomingStructOrderForRelocation
     * @return self
     */
    private function setIncomingStructOrderForRelocation($incomingStructOrderForRelocation)
    {
        Assert::isInstanceOf(
            $incomingStructOrderForRelocation,
            'sspat\ShmelAPI\Struct\IncomingStructOrderForRelocation'
        );
        $this->incomingStructOrderForRelocation = $incomingStructOrderForRelocation;
        return $this;
    }
}
