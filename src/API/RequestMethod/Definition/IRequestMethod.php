<?php

namespace brunohanai\ZabbixAPI\API\RequestMethod\Definition;

interface IRequestMethod
{
    public function getMethod();

    public function getParams();
}