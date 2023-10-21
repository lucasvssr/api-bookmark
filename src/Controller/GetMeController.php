<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class GetMeController extends AbstractController
{
    public function __invoke(): UserInterface
    {
        $user = $this->getUser();
        if (!isset($user)) {
            throw $this->createNotFoundException('User not found');
        }

        return $user;
    }
}
