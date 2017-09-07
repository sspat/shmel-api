<?php
namespace sspat\ShmelAPI;

use sspat\ShmelAPI\Cache\NullCache;
use sspat\ShmelAPI\Contracts\Cache;
use sspat\ShmelAPI\Contracts\Facade;
use sspat\ShmelAPI\Contracts\Request;
use sspat\ShmelAPI\Contracts\Response;
use sspat\ShmelAPI\Exceptions\ShmelAPICacheException;
use sspat\ShmelAPI\Exceptions\ShmelAPIFacadeException;
use sspat\ShmelAPI\Exceptions\ShmelAPISoapException;
use SoapClient;
use SoapFault;

final class API implements Facade
{
    /** Endpoint for testing */
    const TEST_ENDPOINT = 'http://185.68.208.204:60080/tg-demo2/ws/ws1.1cws?wsdl';

    /** Endpoint for production */
    const PRODUCTION_ENDPOINT = 'http://185.68.208.204:60080/tg/ws/ws1.1cws?wsdl';

    /** @var SoapClient */
    private $soapClient;

    /** @var Cache */
    private $cache;

    /**
     * API constructor.
     * @param string $endpoint
     * @param array|null $options
     */
    public function __construct($endpoint, $options = null)
    {
        $this->soapClient = $this->setUpClient($endpoint, $options);
        $this->cache = new NullCache();
    }

    /**
     * @param Cache $cacheDriver
     * @throws ShmelAPIFacadeException
     */
    public function setCacheDriver($cacheDriver)
    {
        if (!($cacheDriver instanceof Cache)) {
            throw new ShmelAPIFacadeException('Cache driver must implement Cache contract');
        }

        $this->cache = $cacheDriver;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ShmelAPISoapException
     * @throws ShmelAPICacheException
     */
    public function sendRequest($request)
    {
        $responseClassFQCN = $request::getResponseFQCN();

        try {
            return new $responseClassFQCN(
                $this->cache->getOrSet(
                    $request::getCacheCategory(),
                    $request->getCacheId(),
                    function () use ($request) {
                        return $this->soapClient->__soapCall(
                            $request::getMethodName(),
                            $request->getParameters()
                        );
                    }
                )
            );
        } catch (SoapFault $e) {
            throw new ShmelAPISoapException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $endpoint
     * @param array|null $options
     * @return SoapClient
     */
    private function setUpClient($endpoint, $options)
    {
        return new SoapClient(
            $endpoint,
            array_merge(
                ['soap_version' => SOAP_1_2],
                $options ?: []
            )
        );
    }
}
