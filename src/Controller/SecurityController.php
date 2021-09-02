<?php

namespace App\Controller;

use App\Form\UserFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guard, LoginAuthenticator $formAuthenticator)
    {
        $form = $this->createForm(UserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gracias a Form, como este formulario está asociado a la entidad user, sus datos se setean automáticamente en un nuevo objeto $user.
            $user = $form->getData();

            // Tratamiento especial para la contraseña: hay que hashearla.
            $password = $user->getPassword();
            $passwordEncode = $encoder->encodePassword($user, $password);
            $user->setPassword($passwordEncode);

            // Asigno un rol manualmente porque este dato no aparece en el formulario.
            $user->setRoles(['ROLE_USER']);

            $doctrine->persist($user);
            $doctrine->flush();

            // TODO: Añadir mensaje flash.

            return $this->redirectToRoute('app_login');
        }

        return $this->render('/security/register.html.twig', ['registerForm'=>$form->createView()]);
    }
}
