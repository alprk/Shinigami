<?php

/**

 * Created by PhpStorm.

 * User: Etudiant0

 * Date: 02/07/2018

 * Time: 10:37

 */
namespace App\Controller\Security;

use App\Form\CustomerType;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller

{
    /**

     * Connexion d'un utilisateur

     * @Route("/login", name="security_login")

     * @param Request $request

     * @param AuthenticationUtils $authenticationUtils

     */

    public function login(Request $request, AuthenticationUtils $authenticationUtils)

    {

        # Si notre utilisateur est deja authentifié, on le redirige vers l'accueil

        if ($this->getUser()) {

            return $this->redirectToRoute('index');

        }
        # Récupération du formulaire

        $form = $this->createForm(LoginType::class, [

            'username' => $authenticationUtils->getLastUsername()

        ]);

        # Récupération du message d'érreur si il y en a un

        $error = $authenticationUtils->getLastAuthenticationError();

        #Dernier email saisi par l'utilisateur

        return $this->render('Security/login.html.twig', [

            'form' => $form->createView(),

            'error' => $error

        ]);

    }

    /**

 * Déconnexion d'un utilisateur

 * @Route("/deconnexion", name="security_logout")

 */

    public function logout()

    {

    }
    /**

 * Vous pourriez définir aussi ici ,

 * votre logique, mot de passe oublié,

 * réinitilaisation du mot de passe et

 * Email de validation.

 */

}