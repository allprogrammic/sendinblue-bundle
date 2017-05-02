<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;

class PlanInformation
{
    const PLAN_FREE = 'FREE';
    const PLAN_SMS = 'SMS';

    const CREDIT_TYPE_SENDLIMIT = 'Send Limit';

    private $planType;

    private $credits;

    private $creditType;

    public static function fromResponse(array $data)
    {
        $object = new self();

        $object->planType = $data['plan_type'];
        $object->credits = $data['credits'];
        $object->creditType = $data['credit_type'];

        return $object;
    }
}