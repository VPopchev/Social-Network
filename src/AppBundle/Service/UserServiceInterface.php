<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 22.1.2018 г.
 * Time: 12:04 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

interface UserServiceInterface
{
    public function register(User $user): bool;

    public function findAll();

    public function addFriend(User $user,User $friend): bool;

    public function findByUsername(string $username);

    public function findByEmail(string $email);
}