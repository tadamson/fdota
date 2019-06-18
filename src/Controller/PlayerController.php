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
    /*
     * @Rest\Get("/players")
     * @return Response
     */
    public function getPlayersAction()
    {
        $r = $this->getDoctrine()->getRepository(Player::class);
        $players = $r->findAll();
        return $this->handleView($this->view($players));
    }

    /**
     * @Rest\Get("/player/{slug}")
     * @return Response
     */
    public function getPlayerAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository(Player::class);
        $player = $repository->findPlayer($slug);
        return $this->handleView($this->view($player));
    }

    /**
     * Create player.
     * @Rest\Post("/player")
     *
     * @return Response
     */
    public function postPlayerAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}