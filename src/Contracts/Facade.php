<?php
namespace sspat\ShmelAPI\Contracts;

interface Facade
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
