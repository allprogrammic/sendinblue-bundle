<?php

namespace AllProgrammic\Bundle\SendinBlueBundle\Api;

class FolderInformation
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var integer */
    private $uniqueSubscribers;

    /** @var integer */
    private $totalSubscribers;

    /** @var integer */
    private $totalBlacklisted;

    /** @var array|ListInformation[] */
    private $lists;

    /**
     * @return integer
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
     * @return integer
     */
    public function getUniqueSubscribers()
    {
        return $this->uniqueSubscribers;
    }

    /**
     * @return integer
     */
    public function getTotalSubscribers()
    {
        return $this->totalSubscribers;
    }

    /**
     * @return integer
     */
    public function getTotalBlacklisted()
    {
        return $this->totalBlacklisted;
    }

    /**
     * @return mixed
     */
    public function getLists()
    {
        return $this->lists;
    }

    public static function fromResponse(array $data)
    {
        $object = new self();

        $object->id = $data['id'];
        $object->name = $data['name'];
        $object->uniqueSubscribers = $data['unique_subscribers'];
        $object->totalSubscribers = $data['total_subscribers'];
        $object->totalBlacklisted = $data['total_blacklisted'];
        $object->lists = array_map([ListInformation::class, 'fromResponse'], $data['lists']);

        return $object;
    }
}