<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;

class AccountInformation
{
    private $clientId;

    private $firstName;

    private $lastName;

    private $email;

    private $company;

    private $address;

    private $city;

    private $postalCode;

    private $country;

    private $plans;

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getPlans()
    {
        return $this->plans;
    }

    public static function fromResponse(array $data)
    {
        $object = new self();

        $object->clientId = $data[2]['client_id'];
        $object->firstName = $data[2]['first_name'];
        $object->lastName = $data[2]['last_name'];
        $object->email = $data[2]['email'];
        $object->company = $data[2]['company'];
        $object->address = $data[2]['address'];
        $object->city = $data[2]['city'];
        $object->postalCode = $data[2]['zip_code'];
        $object->country = $data[2]['country'];

        $object->plans = [];
        $object->plans[] = PlanInformation::fromResponse($data[0]);
        $object->plans[] = PlanInformation::fromResponse($data[1]);

        return $object;
    }
}