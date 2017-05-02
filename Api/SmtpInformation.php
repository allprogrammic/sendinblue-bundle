<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;

class SmtpInformation
{
    private $trackingSiteId;

    private $trackingEmail;

    private $trackingFirstname;

    private $trackingLastname;

    private $trackingCompanyName;

    private $relayStatus;

    private $relayUsername;

    private $relayPassword;

    private $relayServer;

    private $relayPort;

    /**
     * @return mixed
     */
    public function getTrackingSiteId()
    {
        return $this->trackingSiteId;
    }

    /**
     * @return mixed
     */
    public function getTrackingEmail()
    {
        return $this->trackingEmail;
    }

    /**
     * @return mixed
     */
    public function getTrackingFirstname()
    {
        return $this->trackingFirstname;
    }

    /**
     * @return mixed
     */
    public function getTrackingLastname()
    {
        return $this->trackingLastname;
    }

    /**
     * @return mixed
     */
    public function getTrackingCompanyName()
    {
        return $this->trackingCompanyName;
    }

    /**
     * @return mixed
     */
    public function getRelayStatus()
    {
        return $this->relayStatus;
    }

    /**
     * @return mixed
     */
    public function getRelayUsername()
    {
        return $this->relayUsername;
    }

    /**
     * @return mixed
     */
    public function getRelayPassword()
    {
        return $this->relayPassword;
    }

    /**
     * @return mixed
     */
    public function getRelayServer()
    {
        return $this->relayServer;
    }

    /**
     * @return mixed
     */
    public function getRelayPort()
    {
        return $this->relayPort;
    }

    public static function fromResponse(array $data)
    {
        $object = new self();

        $object->trackingSiteId = $data['tracking_data']['site_id'];
        $object->trackingEmail = $data['tracking_data']['email'];
        $object->trackingFirstname = $data['tracking_data']['fname'];
        $object->trackingLastname = $data['tracking_data']['lname'];
        $object->trackingCompanyName = $data['tracking_data']['company_name'];

        $object->relayStatus = $data['relay_data']['status'];
        $object->relayUsername = $data['relay_data']['data']['username'];
        $object->relayPassword = $data['relay_data']['data']['password'];
        $object->relayServer = $data['relay_data']['data']['relay'];
        $object->relayPort = $data['relay_data']['data']['port'];

        return $object;
    }
}