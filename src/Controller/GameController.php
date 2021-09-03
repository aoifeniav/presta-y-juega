<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
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

        if ($this->getUser()) {
            $games = $repo->findAllByOwnerDifferentThan($this->getUser()->getId());
        } else {
            $games = $repo->findAll();
        }

        return $this->render("game/game-gallery.html.twig", ["games" => $games]);
    }

    /**
     * @Route("/games/user/{id}", name="userGames")
     */
    public function showUserGames($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        $games = $repo->findAllByOwner($id);

        $repo = $doctrine->getRepository(User::class);
        $user = $repo->find($id);

        return $this->render("game/user-gallery.html.twig", ['games' => $games, 'user' => $user]);
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
