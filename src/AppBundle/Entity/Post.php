<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="posts")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={"image/jpeg"},maxSize="5500k")
     */
    private $image;

    /**
     * @var PostLike[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PostLike",mappedBy="post")
     */
    private $likes;

    /**
     * @var Comment[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment",mappedBy="post")
     */
    private $comments;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Post
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * @return User
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return PostLike[]|ArrayCollection
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @return Comment[]|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }



    /**
     * @param PostLike $like
     */
    public function addLike(PostLike $like)
    {
        $this->likes[] = $like;
    }

    public function isLiked(User $user){
        $likes = $this->likes;
        /** @var PostLike $like */
        foreach ($likes as $like){
            if ($like->getUser() === $user){
                return true;
            }
        }
        return false;
    }

}

