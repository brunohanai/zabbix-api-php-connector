<?php

namespace brunohanai\ZabbixAPI\API\RequestMethod;

use brunohanai\ZabbixAPI\API\RequestMethod\Definition\RequestMethodAbstract;

class EventMethod extends RequestMethodAbstract
{
    const METHOD = 'event';

    const PARAM_FILTER = 'filter';
    const PARAM_HOSTIDS = 'hostids';
    const PARAM_GROUPIDS = 'groupids';

    public function getAcceptedParams()
    {
        return array(
            'get' => array(
                self::PARAM_FILTER,
                self::PARAM_HOSTIDS,
                self::PARAM_GROUPIDS,
            ),
        );
    }

    public function setHostIds($host_ids)
    {
        $this->setParam($this::PARAM_HOSTIDS, $host_ids);

        return $this;
    }

    public function setGroupIds($group_ids)
    {
        $this->setParam($this::PARAM_GROUPIDS, $group_ids);

        return $this;
    }

    public function setTimeFrom($time_from)
    {
        $this->setParam($this::PARAM_GLOBAL_FILTER_TIMEFROM, $time_from);

        return $this;
    }
}