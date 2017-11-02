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

    /**
     * @return bool
     */
    public function hasBeenOpened(): bool
    {
        return $this->openedAt !== null;
    }

    /**
     * @return bool
     */
    public function hasBeenClicked(): bool
    {
        return $this->clickedAt !== null;
    }

    /**
     * @return int
     */
    public function openCount(): integer
    {
        return count($this->opens);
    }

    /**
     * @return int
     */
    public function clickCount(): integer
    {
        return count($this->clicks);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return \DateTime|null
     */
    public function getSentAt(): ?\DateTime
    {
        return $this->sentAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeliveredAt(): ?\DateTime
    {
        return $this->deliveredAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getOpenedAt(): ?\DateTime
    {
        return $this->openedAt;
    }
}