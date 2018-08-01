<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Story
 *
 * @ORM\Table(name="story")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoryRepository")
 */
class Story
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startTime", type="datetime")
     */
    private $startTime;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="stories")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={"image/jpeg"},maxSize="5500k")
     */
    private $picture;

    /**
     * @var User[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="users_stories",
     *     joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="story_id",referencedColumnName="id",onDelete="CASCADE")})
     */
    private $viewers;

    public function __construct()
    {
        $this->viewers = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Story
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getViewers()
    {
        return $this->viewers;
    }

    /**
     * @param User $viewer
     */
    public function addViewer(User $viewer)
    {
        $this->viewers[] = $viewer;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function areViewedByUser(User $user)
    {
        return $this->getViewers()->contains($user);
    }

}

