<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;


class ListInformation
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var integer */
    private $totalSubscribers;

    /** @var integer */
    private $totalBlacklisted;

    /** @var integer */
    private $folderId;

    /** @var \DateTime */
    private $createdAt;

    /** @var mixed */
    private $stats;

    /** @var boolean */
    private $dynamic;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTotalSubscribers()
    {
        return $this->totalSubscribers;
    }

    /**
     * @return int
     */
    public function getTotalBlacklisted()
    {
        return $this->totalBlacklisted;
    }

    public static function fromResponse(array $data)
    {
        $object = new self();

        $object->id = $data['id'];
        $object->name = $data['name'];
        $object->totalSubscribers = $data['total_subscribers'];
        $object->totalBlacklisted = $data['total_blacklisted'];

        if (isset($data['list_parent'])) {
            $object->folderId = $data['list_parent'];
        }

        if (isset($data['entered'])) {
            $object->createdAt = new \DateTime($data['entered']);
        }

        if (isset($data['camp_stats'])) {
            $object->stats = $data['camp_stats'];
        }

        if (isset($data['dynamic_list'])) {
            $object->dynamic = $data['dynamic_list'] === 1;
        }

        return $object;
    }
}