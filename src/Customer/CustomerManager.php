<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 14:30
 */

namespace App\Customer;


use App\Entity\Card;
use App\Entity\Customer;
use App\Entity\Employee;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerManager
{
    private $manager;
    private $customerFactory;

    private $em;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \Swift_Mailer;
     */
    private $mailer;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(ObjectManager $manager,CustomerFactory $customerFactory, EntityManagerInterface $em, \Twig_Environment $twig, \Swift_Mailer $mailer, UserPasswordEncoderInterface $encoder, FlashBagInterface $flashBag)
    {
        $this->manager = $manager;
        $this->customerFactory = $customerFactory;
        $this->em = $em;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->encoder = $encoder;
        $this->flashBag = $flashBag;

    }



    public function registerAsCustomer(CustomerRequest $customerRequest): Customer
    {
        $em = $this->em;

        # On appel notre Factory pour créer notre Objet Customer
        $customer = $this->customerFactory->createFromCustomerRequest($customerRequest);

        $email = $customer->getEmail();
        $username = $customer->getUsername();

        $customerFound = $em->getRepository(Customer::class)->findOneBy(array(
            'username' => $username ));

        $customerFound2 = $em->getRepository(Customer::class)->findOneBy(array(
            'email' => $email
        ));

        if($customerFound !== null){
            $this->flashBag->add('error', 'Ce nom d\'utilisateur est déjà pris');
        }elseif($customerFound2 !== null){
            $this->flashBag->add('error', 'Cet e-mail est déjà utilisé');
        }

        if($customerFound == null && $customerFound2 == null ){
            # On sauvegarde en BDD notre Customer
            $this->manager->persist($customer);
            $this->manager->flush();

            $this->flashBag->add('success', "Félicitations, vous êtes maintenant inscrit !");
        }

        # On retourne le nouveau Customer
        return $customer;
    }

    public function update(CustomerRequest $customerRequest,Customer $customer): Customer
    {
        $customer = $this->customerFactory->updatefromcustomerrequest($customerRequest,$customer);
        $this->manager->persist($customer);
        $this->manager->flush();

        return $customer;
    }


    public function forgotPassword($username){
        $customer = $this->findCustomerOrEmployee($username);
        $mailer = $this->mailer;

        $this->sendResetPasswordMail($mailer, $customer);
    }

    public function resetPassword($customer, $newPassword){
        $this->changePassword($customer, $newPassword);
    }

    public function attachCard($user, $cardNumber){
        $em = $this->em;
        $result = false;

        $card = $this->findCard($cardNumber);
        $customer = $em->getRepository(Customer::class)->find($user->getId());
        $centerCode = $customer->getCenter()->getCode();
        $codeValid = $this->checkCenterCode($centerCode, $cardNumber);

        if($card === null){
            $this->flashBag->add('notice', 'Carte inexistante');
        }

        if(!$codeValid && $card !== null){
           $this->flashBag->add('notice', 'Cette carte n\'est pas de votre centre');
        }

        if ($card !== null && $codeValid){
            $result = true;
            $card->setCustomer($customer);
            $card->setCustomerNickname($customer->getNickname());
            $customer->setCard($card);

            $this->flashBag->add('notice', 'Carte rattachée');

            $em->persist($customer);
            $em->persist($card);
            $em->flush();
        }

        return $result;
    }

    public function hasCard($customer){
        $result = false;
        if($customer->getCard() !== null){
            $result = true;
        }

        return $result;
    }

    private function checkCenterCode($centerCode, $cardNumber)
    {
        $result = false;
        $cardCode = substr($cardNumber, 0, 3);

        if($cardCode == $centerCode){
            $result = true;
        }

        return $result;
    }

    private function findCard($cardNumber){
        $em = $this->em;

        $card = $em->getRepository(Card::class)->findByCode($cardNumber);

        return $card;
    }

    public function findByToken($token){
        $em = $this->em;
        $customer = $em->getRepository(Customer::class)->findOneBy(
            array('token' => $token));

        //Si c'est un employé qui a demandé un reset du mot de passe
        if($customer == null){
            $customer = $em->getRepository(Employee::class)->findOneBy(
                array('token' => $token));
        }

        return $customer;

    }

    public function checkExpirationDate($customer){
        $expirationDate = $customer->getExpirationdate();
        $expirationDateString = $expirationDate->format("Y-m-d");

        if(strtotime(date("Y-m-d")) < strtotime($expirationDateString)){
            return true;
        }

        return false;
    }

    private function changePassword($customer, $newPassword){
        $em = $this->em;
        $encoder = $this->encoder;

        $customer->setPassword($encoder->encodePassword($customer, $newPassword));

        $customer->setToken(null);
        $customer->setExpirationdate(null);

        $em->persist($customer);
        $em->flush();
    }

    private function findCustomerOrEmployee($username)
    {
        $em = $this->em;
        $repository = $em->getRepository(Customer::class);

        $customer = $repository->findOneBy(
            array('username' => $username ));

        //Si c'est un employé qui a demandé un reset du mot de passe
        if($customer == null){
            $repository = $em->getRepository(Employee::class);
            $customer = $repository->findOneBy(array
            ('username' => $username ));
        }
        return $customer;
    }



    /**
     * @param $token
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private function renderMailContent($token){
        return $this->twig->render('email_reset_password.html.twig', array
        ('param' => $token));
    }

    private function generateMail($token, $email){
        $message = (new \Swift_Message('Réinitialisation de votre mot de passe Lasergame WF3'))
            ->setFrom('lasergamewf3@gmail.com')
            ->setTo($email)
            ->setBody($this->renderMailContent($token),'text/html');

        return $message;
    }

    private function sendResetPasswordMail(\Swift_Mailer $mailer, $customer)
    {
        $em = $this->em;

        $email = $customer->getEmail();

        $token = $this->createToken($customer);
        $expirationDate = $this->generateExpirationDate();

        $customer->setToken($token);
        $customer->setExpirationdate($expirationDate);

        $em->persist($customer);
        $em->flush();

        $message = $this->generateMail($token, $email);

        $mailer->send($message);
    }

    private function createToken($customer)
    {
        $email = $customer->getEmail();
        $token = $token = md5($email . date("Y-m-d"));

        return $token;
    }

    private function generateExpirationDate(){
        $demain = date('Y-m-d', strtotime('+1 day'));
        $dateDemain = new DateTime($demain);

        return $dateDemain;
    }


}