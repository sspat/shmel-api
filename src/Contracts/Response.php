<?php
namespace sspat\ShmelAPI\Contracts;

interface Response
{
    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return Request
     */
    public function getRequest();
}
