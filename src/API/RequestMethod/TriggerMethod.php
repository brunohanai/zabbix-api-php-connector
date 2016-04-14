<?php

namespace brunohanai\ZabbixAPI\API\RequestMethod;

use brunohanai\ZabbixAPI\API\RequestMethod\Definition\RequestMethodAbstract;

class TriggerMethod extends RequestMethodAbstract
{
    const METHOD = 'trigger';

    const PARAM_FILTER = 'filter';
    const PARAM_HOSTIDS = 'hostids';
    const PARAM_TRIGGERIDS = 'triggerids';

    public function getAcceptedParams()
    {
        return array(
            'get' => array(
                self::PARAM_FILTER,
                self::PARAM_HOSTIDS,
                self::PARAM_TRIGGERIDS,
            ),
        );
    }

    public function setHostIds($host_ids)
    {
        $this->setParam($this::PARAM_HOSTIDS, $host_ids);

        return $this;
    }

    public function setTriggerIds($trigger_ids)
    {
        $this->setParam($this::PARAM_TRIGGERIDS, $trigger_ids);

        return $this;
    }
}