<?php

namespace brunohanai\ZabbixAPI\API\RequestMethod\Definition;

use brunohanai\ZabbixAPI\API\APIConnector;

abstract class RequestMethodAbstract
{
    const METHOD = 'abstract';
    const PARAM_GLOBAL_FILTER_TIMEFROM = 'time_from';
    const PARAM_GLOBAL_OUTPUT = 'output';
    const PARAM_GLOBAL_LIMIT = 'limit';
    const PARAM_GLOBAL_COUNT_OUTPUT = 'countOutput';

    private $connector;
    private $action;
    private $params;

    abstract function getAcceptedParams();
    
    public function __construct(APIConnector $connector = null)
    {
        $this->connector = $connector;
    }

    public function request($token = null)
    {
        if ($this->connector === null) {
            throw new \Exception(sprintf('You must set a APIConnector.'));
        }

        return $this->connector->request($this->getMethod(), $this->getParams(), $token);
    }

    public function setParam($key, $value)
    {
        $globalAcceptedParams = $this->getAcceptedGlobalParams();
        $acceptedParams = $this->getAcceptedParams();

        if ($this->action !== null) {
            $globalAcceptedParams = $globalAcceptedParams[$this->action];
            $acceptedParams = $acceptedParams[$this->action];
        }

        if (!in_array($key, $acceptedParams) && !in_array($key, $globalAcceptedParams)) {
            throw new \Exception(sprintf('Param [%s] is not supported by [%s].', $key, $this->getName()));
        }

        $this->params[$key] = $value;

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setConnector(APIConnector $connector)
    {
        $this->connector = $connector;

        return $this;
    }

    public function getMethod()
    {
        if ($this->action === null) {
            return $this->getName();
        }

        return sprintf('%s.%s', $this->getName(), $this->getAction());
    }

    public function getName()
    {
        return $this::METHOD;
    }

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    private function getAcceptedGlobalParams()
    {
        return array(
            'get' => array(
                self::PARAM_GLOBAL_FILTER_TIMEFROM,
                self::PARAM_GLOBAL_OUTPUT,
                self::PARAM_GLOBAL_LIMIT,
                self::PARAM_GLOBAL_COUNT_OUTPUT,
            ),
        );
    }
}