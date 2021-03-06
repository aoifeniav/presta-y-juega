<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Form\GameFormType;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/user-area", name="userArea")
     */
    public function user()
    {
        return $this->render('/user/user-area.html.twig');
    }

        /**
     * @Route("/user/edit", name="editUser")
     */
    public function register(Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $encoder)
    {
        $repo = $doctrine->getRepository(User::class);
        $user = $repo->find($this->getUser());

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $user->getPassword();
            $passwordEncode = $encoder->encodePassword($user, $password);
            $user->setPassword($passwordEncode);

            $doctrine->persist($user);
            $doctrine->flush();

            $this->addFlash('userInfoEditSuccessful', 'Tus datos de usuario se han guardado correctamente.');

            return $this->redirectToRoute('userArea');
        }

        return $this->render('/security/register.html.twig', ['registerForm'=>$form->createView()]);
    }

    /**
     * @Route("/user/my-games", name="myGames")
     */
    public function myGames(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        $games = $repo->findBy(['owner' => $this->getUser()]);

        return $this->render('/user/my-games.html.twig', ['games' => $games]);
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

            $user = $this->getUser();
            $game->setOwner($user);

            $doctrine->persist($game);
            $doctrine->flush();

            return $this->redirectToRoute('gameView', ['id' => $game->getId()]);
        }

        return $this->render('/game/add-game.html.twig', ['gameForm' => $form->createView()]);
    }

    /**
     * @Route("/user/game/edit/{id}", name="editGame")
     */
    public function editGame($id, Request $request, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Game::class);
        $game = $repo->find($id);

        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $doctrine->persist($game);
            $doctrine->flush();

            return $this->redirectToRoute('gameView', ['id' => $game->getId()]);
        }

        return $this->render('/game/edit-game.html.twig', ['gameForm' => $form->createView(), 'game' => $game]);
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

        $this->addFlash('deletionSuccessful', 'Se ha eliminado el juego correctamente.');

        return $this->redirectToRoute('myGames');
    }

    /**
     * @Route("/user/my-exchanges", name="myExchanges")
     */
    public function myExchanges(EntityManagerInterface $doctrine)
    {
        // TODO: Obtener operations del usuario loggeado y pintar un solo div.
        $repo = $doctrine->getRepository(Operation::class);
        // $exchanges = $repo->findBy(['borrower'=>$userId, 'lender'=>$userId]);

        // return $this->render('/user/my-exchanges.html.twig', ['exchanges' => $exchanges]);
    }

    /**
     * @Route("/user/exchange/{id}", name="exchangeView")
     */
    public function exchangeView($id, EntityManagerInterface $doctrine)
    {
        // TODO: Obtener las operations con el operationId y usarlas para mostrar diferente informaci??n sobre el intercambio.
        $repo = $doctrine->getRepository(Operation::class);
        $operationsAsBorrower = $repo->find($id);
        $operationsAsLender = $repo->find($id);

        return $this->render('/user/exchange-view.html.twig', ['operationsAsBorrower' => $operationsAsBorrower, 'operationsAsLender' => $operationsAsLender]);
    }
}
