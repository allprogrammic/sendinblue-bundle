<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;


class UserInformation
{
    private $email;

    private $createdAt;

    private $blacklisted;

    private $attributes;

    private $listIds;

    private $messageSent;

    private $hardBounces;

    private $softBounces;

    private $spam;

    private $unsubscription;

    private $opened;

    private $clicks;

    private $blacklistedSms;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return boolean
     */
    public function isBlacklisted()
    {
        return $this->blacklisted;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getListIds()
    {
        return $this->listIds;
    }

    /**
     * @return mixed
     */
    public function getMessageSent()
    {
        return $this->messageSent;
    }

    /**
     * @return mixed
     */
    public function getHardBounces()
    {
        return $this->hardBounces;
    }

    /**
     * @return mixed
     */
    public function getSoftBounces()
    {
        return $this->softBounces;
    }

    /**
     * @return mixed
     */
    public function getSpam()
    {
        return $this->spam;
    }

    /**
     * @return mixed
     */
    public function getUnsubscription()
    {
        return $this->unsubscription;
    }

    /**
     * @return mixed
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * @return mixed
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * @return boolean
     */
    public function isBlacklistedSms()
    {
        return $this->blacklistedSms;
    }

    public static function fromResponse(array $data)
    {
        $object = new self();

        $object->email = $data['email'];
        $object->createdAt = new \DateTime($data['entered']);
        $object->blacklisted = $data['blacklisted'] === 1;
        $object->attributes = $data['attributes'];
        $object->listIds = $data['listid'];
        $object->messageSent = $data['message_sent'];
        $object->hardBounces = $data['hard_bounces'];
        $object->softBounces = $data['soft_bounces'];
        $object->spam = $data['spam'];
        $object->unsubscription = $data['unsubscription'];
        $object->opened = $data['opened'];
        $object->clicks = $data['clicks'];
        $object->blacklistedSms = $data['blacklisted_sms'] === 1;

        return $object;
    }
}