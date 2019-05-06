<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Player;
use App\Form\PlayerType;


/**
 * Player controller.
 * @Route("/api", name="api_")
 */
class PlayerController extends FOSRestController
{
    /**
     * Lists all players
     * @Rest\Get("/players")
     *
     * @return Response
     */
    public function getPlayerAction()
    {
        $repository = $this->getDoctrine()->getRepository(Player::class);
        $movies = $repository->findall();
        return $this->handleView($this->view($movies));
    }

    /**
     * Create player.
     * @Rest\Post("/player")
     *
     * @return Response
     */
    public function postPlayerAction(Request $request)
    {
        $movie = new Player();
        $form = $this->createForm(PlayerType::class, $movie);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}