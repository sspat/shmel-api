<?php
namespace sspat\ShmelAPI;

use sspat\ShmelAPI\Cache\NullCache;
use sspat\ShmelAPI\Contracts\Cache;
use sspat\ShmelAPI\Contracts\Facade;
use sspat\ShmelAPI\Contracts\Request;
use sspat\ShmelAPI\Contracts\Response;
use sspat\ShmelAPI\Exceptions\ShmelAPICacheException;
use sspat\ShmelAPI\Exceptions\ShmelAPISoapException;
use SoapClient;
use SoapFault;

class API implements Facade
{
    /** Endpoint for testing, used by default */
    const TEST_ENDPOINT = 'http://185.68.208.204:60080/tg-demo2/ws/ws1.1cws?wsdl';

    /** Endpoint for production */
    const PRODUCTION_ENDPOINT = 'http://185.68.208.204:60080/tg/ws/ws1.1cws?wsdl';

    /** @var SoapClient */
    private $soapClient;

    /** @var Cache */
    private $cache;

    /**
     * API constructor.
     * @param string $login
     * @param string $password
     * @param bool $productionMode
     */
    public function __construct($login, $password, $productionMode = false)
    {
        // We use the test endpoint by default, to prevent accidental corruption of data on the production server
        $endpoint = $productionMode ? self::PRODUCTION_ENDPOINT : self::TEST_ENDPOINT;
        $this->soapClient = $this->setUpClient($login, $password, $endpoint);
        $this->cache = new NullCache();
    }

    /**
     * @param Cache $cacheDriver
     */
    public function setCacheDriver($cacheDriver)
    {
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
     * @param string $login
     * @param string $password
     * @param string $endpoint
     * @return SoapClient
     */
    protected function setUpClient($login, $password, $endpoint)
    {
        return new SoapClient(
            $endpoint,
            [
                'login' => $login,
                'password' => $password,
                'soap_version' => SOAP_1_2
            ]
        );
    }
}
