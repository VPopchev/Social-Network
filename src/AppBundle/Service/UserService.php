<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 22.1.2018 г.
 * Time: 12:04 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EntityManager $entityManager
     */
    public function __construct(UserRepository $userRepository,
                                EntityManager $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }


    public function register(User $user): bool
    {
        $password = password_hash($user->getPassword(),PASSWORD_BCRYPT);
        $user->setPassword($password);
        $profilePicture = $user->getProfilePicture();
        $fileUploader = new FileUploader('app/images/users');
        $fileName = $fileUploader->upload($profilePicture);
        $user->setProfilePicture($fileName);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return true;
    }

    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    public function addFriend(User $user, User $friend): bool
    {
        $user->addFriend($friend);
        $this->entityManager->flush();
        return true;
    }

    public function findByUsername(string $username)
    {
        return $this->userRepository->findByUsername($username);
    }

    public function findByEmail(string $email)
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }
}