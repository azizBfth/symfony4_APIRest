<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
//use FOS\RestBundle\Controller\Annotations\Get; // N'oublons pas d'inclure Get
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use App\Entity\User;

class UserController extends AbstractController
{
     /**
     * @Rest\View() 
     * @Rest\Get("/users")
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findAll();
        

        
        return $users;
        //return new JsonResponse($users);
        
    }
    
     /**
     * @Rest\View() 
     * @Rest\Get("/users/{user_id}")
     */
    public function getUserAction($user_id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        /* @var $user User */
        
        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        
        return $user;
    }
}
