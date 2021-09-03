<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class GameController extends AbstractController
{
    /**
     * @Route("/games", name="gameGallery")
     */
    public function listGames(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        // TODO: Cambiar que devuelva los juegos del user por todos los user que no sean el logueado.
        $games = $repo->findBy(['owner'=>$this->getUser()], null, 20);

        return $this->render("game/game-gallery.html.twig", ["games" => $games]);
    }

    /**
     * @Route("/game/{id}", name="gameView")
     */
    public function showGame($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        $game = $repo->find($id);

        return $this->render("game/game-view.html.twig", ['game' => $game]);
    }
}