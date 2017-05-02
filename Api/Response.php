<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;

class Response
{
    public $code;

    public $message;

    public $data;

    public function __construct($code, $message, array $data = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function isSuccess()
    {
        return $this->code === 'success';
    }
}