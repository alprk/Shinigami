<?php

/**

 * Created by PhpStorm.

 * User: Etudiant0

 * Date: 02/07/2018

 * Time: 10:37

 */
namespace App\Controller\Security;

use App\Customer\CustomerManager;
use App\Form\CustomerType;

use App\Form\ForgotPasswordType;
use App\Form\LoginType;
use App\Form\ResetPasswordType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller

{

    private $logger;

    /**
     * EmployeeController constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
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

    /**
     * @Route("/forgot_password", name="customer_forgot_password", methods={"GET", "POST"})
     */
    public function forgotPassword(Request $request, CustomerManager $manager)
    {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test = $form->getData();
            $username = $test['username'];

            $manager->forgotPassword($username);

            $this->log('Demande de réinitialisation du mot de passe pour l\'utilisateur '.$username );


            return $this->render('index.html.twig', [
                'success' => 'Un e-mail de réinitialisation de votre mot de passe vous a été envoyé!'
            ]);
        }

        return $this->render('forgot_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset_password", name="customer_reset_password", methods={"GET", "POST"})
     */
    public function resetPassword(Request $request, CustomerManager $manager)
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        $token = $request->get('user');
        if($token != null){
            $customer = $manager->findByToken($token);
            if(!$manager->checkExpirationDate($customer)){
                throw $this->createNotFoundException();
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $test = $form->getData();
            $newPassword = $test['password'];

            $manager->resetPassword($customer, $newPassword);

            $this->log('Réinitialisation du mot de passe pour' . $customer->getUsername() );


            return $this->render('index.html.twig', [
                'success' => 'Votre mot de passe a bien été réinitialisé!'
            ]);
        }

        return $this->render('reset_password.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function log($message)
    {
        $this->logger->info($message);

    }

}