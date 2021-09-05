<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameRequest;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class GameRequestController extends AbstractController
{
     /**
     * @Route("/game-request/{game}/borrower/{user}", name="sendRequest")
     */
    public function sendRequest($game, $user, EntityManagerInterface $doctrine)
    {
        $doctrine->getRepository(GameRequest::class);
        $gameRepo = $doctrine->getRepository(Game::class);
        $userRepo = $doctrine->getRepository(User::class);

        $game = $gameRepo->find($game);
        $user = $userRepo->find($user);

        $gameRequest = new GameRequest();
        $gameRequest->setGame($game);
        $gameRequest->setBorrower($user);
        $gameRequest->setLender($game->getOwner());
        $gameRequest->setRequestDate(new DateTime());
        $gameRequest->setIsActive(true);

        $doctrine->persist($gameRequest);
        $doctrine->flush();

        return new Response('Game requested successfully.');
    }
}