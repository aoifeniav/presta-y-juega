<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;

class GameController extends AbstractController
{
    /**
     * @Route("/games", name="gameGallery")
     */
    public function listGames(EntityManagerInterface $doctrine, Request $request)
    {
        $repo = $doctrine->getRepository(Game::class);

        if ($this->getUser()) {
            $games = $repo->findAllByOwnerDifferentThan($this->getUser()->getId());
        } else {
            $games = $repo->findAll();
        }

        $search = $request->query->get('search');

        if ($search) {
            $games = $repo->findAllBySearch($search);
        }

        return $this->render('game/game-gallery.html.twig', ['games' => $games]);
    }

    /**
     * @Route("/games/user/{id}", name="userGames")
     */
    public function showUserGames($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(User::class);
        $user = $repo->find($id);

        $repo = $doctrine->getRepository(Game::class);
        $games = $repo->findAllByOwner($id);

        return $this->render('game/user-gallery.html.twig', ['games' => $games, 'user' => $user]);
    }

    /**
     * @Route("/game/{id}", name="gameView")
     */
    public function showGame($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        $game = $repo->find($id);

        return $this->render('game/game-view.html.twig', ['game' => $game]);
    }
}
