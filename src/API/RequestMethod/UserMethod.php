<?php

namespace brunohanai\ZabbixAPI\API\RequestMethod;

use brunohanai\ZabbixAPI\API\RequestMethod\Definition\IRequestMethod;
use brunohanai\ZabbixAPI\API\RequestMethod\Definition\RequestMethodAbstract;

class UserMethod extends RequestMethodAbstract implements IRequestMethod
{
    const METHOD = 'user';

    const PARAM_USER = 'user';
    const PARAM_PASSWORD = 'password';

    public function getAcceptedParams()
    {
        return array(
            'login' => array(self::PARAM_USER, self::PARAM_PASSWORD),
        );
    }

    public function setUser($user)
    {
        $this->setParam($this::PARAM_USER, $user);

        return $this;
    }

    public function setPassword($password)
    {
        $this->setParam($this::PARAM_PASSWORD, $password);

        return $this;
    }
}