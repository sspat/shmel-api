<?php
namespace sspat\ShmelAPI\Responses;

use sspat\ShmelAPI\Contracts\Request;
use sspat\ShmelAPI\Contracts\Response;

class TermsOfRatesForCarsResponse implements Response
{
    /** @var array */
    private $response;

    /** @var Request */
    private $request;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->setResponse($response);
    }

    /**
     * @param object $response
     */
    private function setResponse($response)
    {
        $this->response = array_map(
            function ($rate) {
                return $rate;
            },
            $response->return->GroupTableRatesForCars
        );
    }

    /** @inheritdoc */
    public function getData()
    {
        return $this->response;
    }

    /** @inheritdoc */
    public function getRequest()
    {
        return $this->request;
    }
}
