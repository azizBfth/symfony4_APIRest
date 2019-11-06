<?php

namespace App\Controller;

use Twig\Template;
use App\Entity\Place;

use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
//use FOS\RestBundle\Controller\Annotations\Get;
//use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
//use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
//use FOS\RestBundle\Controller\Annotations\Get;
//use FOS\RestBundle\Controller\Annotations\View;
class PlaceController extends AbstractController
{

 /**
 * @Rest\View(statusCode=Response::HTTP_CREATED)
 * @Rest\Post("/places")
 */
public function postPlacesAction(Request $request)
{
    $place = new Place();
    $place->setName($request->get('name'))
        ->setAddress($request->get('address'));

    $em = $this->getDoctrine()->getManager();
    $em->persist($place);
    $em->flush();

    return $place;
}

     /**
     * @Rest\View() 
     * @Rest\Get("/places")
     */
    public function getPlacesAction()
    {
        $places = $this->getDoctrine()
                ->getRepository(Place::class)
                ->findAll();
        /* @var $places Place[] */

        // Création d'une vue FOSRestBundle
       //$view = View::create($places);
       //$view->setFormat('json');

        return $places;           
    
    }
    /**
     * @Rest\View() 
     * @Rest\Get("/places/{place_id}")
     */
    public function getPlaceAction($place_id)
    {
        $place = $this->getDoctrine()->getRepository(Place::class)->find($place_id);
        /* @var $place Place */
        
        if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        
        return $place;
    }
}
