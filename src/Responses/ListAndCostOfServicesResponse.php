<?php
namespace sspat\ShmelAPI\Responses;

use sspat\ShmelAPI\Contracts\Response;

final class ListAndCostOfServicesResponse implements Response
{
    /** @var array */
    private $response;

    /**
     * ListAndCostOfServicesResponse constructor.
     * @param mixed $response
     */
    public function __construct($response)
    {
        $this->setResponse($response);
    }

    /** @inheritdoc */
    public function getData()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    private function setResponse($response)
    {
        $this->response = array_map(
            function ($rate) {
                return $rate->StructListAndCostOfServices;
            },
            $response->return->GroupTableListAndCostOfServices
        );
    }
}
