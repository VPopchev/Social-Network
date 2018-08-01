<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, JsonSerializable
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var User[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="users_friends",
     *     joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="friend_id",referencedColumnName="id",onDelete="CASCADE")})
     */
    private $friends;

    /**
     * @var Message[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message",mappedBy="sender")
     */
    private $outBox;

    /**
     * @var Message[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message",mappedBy="receiver")
     */
    private $inBox;

    /**
     * @var Post[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Post",mappedBy="owner")
     */
    private $posts;


    /**
     * @var PostLike[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PostLike",mappedBy="user")
     */
    private $likes;

    /**
     * @var Comment[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment",mappedBy="owner")
     */
    private $comments;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={"image/jpeg"},maxSize="5500k")
     */
    private $profilePicture;


    /**
     * @var Story[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Story",mappedBy="owner")
     */
    private $stories;


    public function __construct()
    {
        $this->friends = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->stories = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param User $user
     */
    public function addFriend(User $user)
    {
        $this->friends[] = $user;
    }

    /**
     * @return Message[]|ArrayCollection
     */
    public function getOutBox()
    {
        return $this->outBox;
    }

    /**
     * @param Message[]|ArrayCollection $outBox
     */
    public function setOutBox($outBox)
    {
        $this->outBox = $outBox;
    }

    /**
     * @return Message[]|ArrayCollection
     */
    public function getInBox()
    {
        return $this->inBox;
    }

    /**
     * @param Message[]|ArrayCollection $inBox
     */
    public function setInBox($inBox)
    {
        $this->inBox = $inBox;
    }

    /**
     * @return Post[]|ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;
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
     * @return mixed
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param mixed $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return Story[]|ArrayCollection
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * @param Story $story
     */
    public function addStory(Story $story)
    {
        $this->stories[] = $story;
    }






    /**
     * @param PostLike $like
     */
    public function addLike(PostLike $like)
    {
        $this->likes[] = $like;
    }


    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function areFriends(User $user): bool{
        return $this->getFriends()->contains($user);
    }

    public function getNewMessagesCount(){
        $newMessages = $this->inBox->filter(function (Message $message){
            return $message->getIsRead() == false;
        });
        return $newMessages->count();
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'userName' => $this->getUsername(),
            'profilePicture' => $this->getProfilePicture()
        ];
    }
}

