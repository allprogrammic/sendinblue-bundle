<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;


class TransactionalMessageState
{
    private $id;

    private $to;

    private $from;

    private $subject;

    private $sentAt;

    private $deliveredAt;

    private $openedAt;

    private $opens;

    private $clickedAt;

    private $clicks;

    private function __construct()
    {
        $this->opens = [];
        $this->clicks = [];
    }

    public static function fromResponse($data)
    {
        $object = null;

        $data = array_reverse($data);

        foreach ($data as $event) {
            if (!$object) {
                $object = new self();

                $object->id = $event['message-id'];
                $object->from = $event['from'];
                $object->to = $event['email'];
                $object->subject = $event['subject'];
            }

            switch($event['event']) {
                case 'requests':
                    $object->sentAt = new \DateTime($event['date']);
                    break;
                case 'delivery':
                    $object->deliveredAt = new \DateTime($event['date']);
                    break;
                case 'views':
                    if (!$object->openedAt) {
                        $object->openedAt = new \DateTime($event['date']);
                    }

                    $object->opens[] = [
                        'date' => new \DateTime($event['date']),
                    ];
                    break;
                case 'clicks':
                    if (!$object->clickedAt) {
                        $object->clickedAt = new \DateTime($event['date']);
                    }

                    $object->clicks[] = [
                        'date' => new \DateTime($event['date']),
                        'link' => $event['link'],
                    ];
                    break;
            }
        }

        return $object;
    }

    public function hasBeenOpened()
    {
        return $this->openedAt !== null;
    }

    public function hasBeenClicked()
    {
        return $this->clickedAt !== null;
    }

    public function openCount()
    {
        return count($this->opens);
    }

    public function clickCount()
    {
        return count($this->clicks);
    }
}