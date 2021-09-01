<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/user-area", name="userArea")
     */
    public function user()
    {
        return $this->render("/user/user-area.html.twig");
    }

    /**
     * @Route("/user/my-games", name="myGames")
     */
    public function myGames()
    {
        return $this->render("/user/my-games.html.twig");
    }

    /**
     * @Route("/user/my-exchanges", name="myExchanges")
     */
    public function myExchanges()
    {
        return $this->render("/user/my-exchanges.html.twig");
    }
    
    /**
     * @Route("/user/game/new", name="addGame")
     */
    public function addGame()
    {
        return $this->render("/user/add-game.html.twig");
    }
    
    /**
     * @Route("/user/game/edit/{id}", name="editGame")
     */
    public function editGame()
    {
        return $this->render("/user/edit-game.html.twig");
    }
        
    /**
     * @Route("/user/exchange/{id}", name="exchangeView")
     */
    public function exchangeView()
    {
        return $this->render("/user/exchange-view.html.twig");
    }
}