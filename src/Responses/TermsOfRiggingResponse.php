<?php
namespace sspat\ShmelAPI\Responses;

use sspat\ShmelAPI\Contracts\Response;

final class TermsOfRiggingResponse implements Response
{
    /** @var array */
    private $response;

    /**
     * TermsOfRiggingResponse constructor.
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
                return $rate;
            },
            $response->return->GroupTermsOfRigging
        );
    }
}
