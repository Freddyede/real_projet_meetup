<?php

namespace App\Services;

use App\Entity\Users;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineServices {
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function getUsers(){
        $users = $this->em->getRepository(Users::class)->findAll();
        return $users;
    }
    public function getUser($id){
        return $this->em->getRepository(Users::class)->find($id);
    }
    public function removeUser($id){
        $userDelete = $this->em->getRepository(Users::class)->find($id);
        $this->em->remove($userDelete);
        return $this->em->flush();
    }
}