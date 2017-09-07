<?php
namespace sspat\ShmelAPI\Contracts;

interface Client
{
    /**
     * @param Request $request
     * @return Response
     */
    public function sendRequest($request);

    /**
     * @param Cache $cacheDriver
     * @return void
     */
    public function setCacheDriver($cacheDriver);
}
