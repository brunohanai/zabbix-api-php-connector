<?php

namespace brunohanai\ZabbixAPI\API;

use brunohanai\ZabbixAPI\API\RequestMethod\Definition\IRequestMethod;
use brunohanai\ZabbixAPI\API\RequestMethod\Definition\RequestMethodAbstract;
use brunohanai\ZabbixAPI\API\RequestMethod\EventMethod;
use brunohanai\ZabbixAPI\API\RequestMethod\TriggerMethod;
use brunohanai\ZabbixAPI\API\RequestMethod\UserMethod;

class APIConnector
{
    private $url;
    private $headers;
    private $data;
    private $token;

    public function __construct($url = null, $user, $pass, $token, $should_set_defaults = true)
    {
        $this->url = $url;
        $this->headers = new \ArrayIterator();
        $this->data = new \ArrayIterator();
        $this->token = null;

        if ($should_set_defaults === true) {
            $this->setDefaults();
        }
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function addHeader($key, $value)
    {
        $this->headers->append(sprintf('%s: %s', $key, $value));

        return $this;
    }

    public function addDataValue($key, $value)
    {
        $this->data->offsetSet($key, $value);

        return $this;
    }

    public function request($method, $params, $token = null)
    {
        if ($this->url === null) {
            throw new \Exception('Invalid request. Method was not settled');
        }

        $id = uniqid();
        $this->addDataValue('id', $id);
        $this->addDataValue('auth', $token);
        $this->addDataValue('method', $method);
        $this->addDataValue('params', $params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers->getArrayCopy());
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->data->getArrayCopy()));

        var_dump('Request: '.json_encode($this->data->getArrayCopy()));

        $response = curl_exec($curl);

        var_dump('Response: '.$response);

        curl_close($curl);

        return $response;
    }

    private function setDefaults()
    {
        $this->addHeader('Content-Type', 'application/json-rpc');
        $this->addDataValue('jsonrpc', '2.0');
    }

    private function checkConnection()
    {
        $from = new \DateTime('now');

        $method = new EventMethod();
        $method
            ->setConnector($this)
            ->setAction('get')
            ->setParam($method::PARAM_GLOBAL_LIMIT, 1)
            ->setParam($method::PARAM_GLOBAL_COUNT_OUTPUT, true)
            ->setParam($method::PARAM_GLOBAL_FILTER_TIMEFROM, $from->getTimestamp());
        ;

        //TODO: Lógica para verificar se está conectado...
        //$response = $method->request($token);
    }

    private function connect()
    {
        $method = new UserMethod();
        $response = $method
            ->setConnector($this)
            ->setAction('login')
            ->setUser('user')
            ->setPassword('password')
            ->request(null)
        ;

        //TODO: lógica para verificar se conectou e salvar o token
        $this->token = null;
    }
}