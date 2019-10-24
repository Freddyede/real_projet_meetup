<?php

namespace App\Services;

use App\Entity\Users;

use Doctrine\ORM\EntityManagerInterface;

class FormsServices {
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function sendForm($task) {
        $entityManager = $this->em;
        $entityManager->persist($task);
        $entityManager->flush();
    }
}