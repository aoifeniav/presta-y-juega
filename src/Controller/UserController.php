<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

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
    public function myGames(EntityManagerInterface $doctrine)
    {
        // TODO: Obtener id de usuario loggeado y usarlo para encontrar todos los juegos con dicho id como "owner".
        $repo = $doctrine->getRepository(Game::class);
        // $games = $repo->findBy(["owner"=>$userId]);

        // return $this->render("/user/my-games.html.twig", ["games" => $games]);
    }

    /**
     * @Route("/user/game/new", name="addGame")
     */
    public function addGame(Request $request, EntityManagerInterface $doctrine)
        {
            $form = $this->createForm(GameFormType::class);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $game = $form->getData();
                // Aplicar id de user a owner.
                $game->setOwner();
    
                $doctrine->persist($game);
                $doctrine->flush();
     
                return $this->redirectToRoute('gameView', ['id'=>$game->getId()]);
            }
    
            return $this->render('/game/add-game.html.twig', ['addGameForm'=>$form->createView()]);
    }

    /**
     * @Route("/user/game/edit/{id}", name="editGame")
     */
    public function editGame()
    {
        // TODO: Añadir formulario de edición.
        return $this->render("/user/edit-game.html.twig");
    }

    /**
     * @Route("/user/game/delete/{id}", name="deleteGame")
     */
    public function deleteGame($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        $game = $repo->find($id);

        $doctrine->remove($game);
        $doctrine->flush();

        return $this->redirectToRoute("listPokemons");
        return $this->redirectToRoute("/user/my-games.html.twig");
    }

    /**
     * @Route("/user/my-exchanges", name="myExchanges")
     */
    public function myExchanges(EntityManagerInterface $doctrine)
    {
        // TODO: Obtener operations del usuario loggeado y pintar un solo div.
        $repo = $doctrine->getRepository(Operation::class);
        // $exchanges = $repo->findBy(["borrower"=>$userId, "lender"=>$userId]);

        // return $this->render("/user/my-exchanges.html.twig", ["exchanges" => $exchanges]);
    }

    /**
     * @Route("/user/exchange/{id}", name="exchangeView")
     */
    public function exchangeView($id, EntityManagerInterface $doctrine)
    {
        // TODO: Obtener las operations con el operationId y usarlas para mostrar diferente información sobre el intercambio.
        $repo = $doctrine->getRepository(Operation::class);
        $operationsAsBorrower = $repo->find($id);
        $operationsAsLender = $repo->find($id);

        return $this->render("/user/exchange-view.html.twig", ["operationsAsBorrower" => $operationsAsBorrower, "operationsAsLender" => $operationsAsLender]);
    }
}
