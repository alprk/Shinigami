<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 14:43
 */

namespace App\Controller;


use App\Customer\CustomerManager;
use App\Customer\CustomerRequest;
use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;
use App\Entity\Employee;
use App\Form\AttachCard;
use App\Form\CustomerType;
use App\Form\EmployeeType;
use App\Score\ScoreManager;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomerController extends Controller
{
    private $logger;

    /**
     * CustomerController constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * Inscription d'un Customer
     * @Route("/register_customer",name="customer_register", methods={"GET","POST"})
     */
    public function register(Request $request, CustomerManager $customerManager)
    {
        $customer = new CustomerRequest();

        $form = $this->createForm(CustomerType::class, $customer)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Enregistrement de l'utilisateur
            $customer = $customerManager->registerAsCustomer($customer);

            $this->log('Compte crée pour '. $customer->getUsername());

            # Redirection
            return $this->redirectToRoute('index');
        }

        # Affichage du Formulaire dans la vue
        return $this->render('registration.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/modify_info", name="customer_modify_info", methods={"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function modifyInfo(Request $request, CustomerManager $customerManager,EmployeeManager $employeeManager)

    {
        $ar = $this->getUser();

        if ($ar instanceof Employee)
        {
            $employeerequest = EmployeeRequest::createFromEmployee($ar);
            $options = [
                'etat' => 'Modifier ses informations'
            ];

            $form = $this->createForm(EmployeeType::class, $employeerequest, $options)
                ->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $employee = $employeeManager->update($form->getData(),$ar);

                $this->addFlash('notice', 'Modifications enregistrées !');
                $this->log('Modification des informations personnelles de '. $employee->getUsername());
                return $this->redirectToRoute('index');
            }


            # Affichage du Formulaire dans la vue
            return $this->render('modifyinfo.html.twig', [
                'form' => $form->createView(),
                'status' => 'MODIFICATION_INFO'
            ]);
        }
        else
            {
            $customerrequest = CustomerRequest::createFromCustomer($ar);


            $options = [
                'etat' => 'Modifier ses informations'
            ];


            $form = $this->createForm(CustomerType::class, $customerrequest, $options)
                ->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $customer = $customerManager->update($form->getData(),$ar);
                $this->log('Modification des informations personnelles de '. $customer->getUsername());
                $this->addFlash('notice', 'Modifications enregistrées !');

                return $this->redirectToRoute('index');
            }


            # Affichage du Formulaire dans la vue
            return $this->render('modifyinfo.html.twig', [
                'form' => $form->createView(),
                'status' => 'MODIFICATION_INFO'
            ]);


        }
    }

    /**
     * @Route("/customer_attach_card", name="customer_attach_card", methods={"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function attach_card(Request $request, CustomerManager $manager)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($manager->hasCard($user)) {

            $this->addFlash('danger', 'Vous possédez déja une carte !');

            return $this->render('espace_client.html.twig');



        } else {
            $form = $this->createForm(AttachCard::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $test = $form->getData();
                $card_number = $test['card_number'];

                $result = $manager->attachCard($user, $card_number);
                if ($result !== false) {

                    $this->log('Rattachage de la carte numéro '. $card_number. "à ".$user->getUsername());

                    return $this->render('espace_client.html.twig', [
                        'success' => 'Carte correctement rattachée',
                    ]);

     
                } else {


                    return $this->render('customer_attach_card.html.twig', [
                        'success' => 'Impossible de rattacher cette carte (Elle n\'existe pas)',
                        'form' => $form->createView()
                    ]);

                }

            }

            return $this->render('customer_attach_card.html.twig', [
                'form' => $form->createView(),
            ]);

        }
    }

    /**
     * @Route("/customer_show_scores", name="customer_show_scores", methods={"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function showScores(ScoreManager $manager)
    {
        $customer = $this->get('security.token_storage')->getToken()->getUser();

        $scores = $manager->getScores($customer);

        return $this->render('player_scores.html.twig', [
            'scores' => $scores
        ]);


    }

    /**
     * @Route("/customer_espace_client", name="customer_espace_client", methods={"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function espaceclient(ScoreManager $manager)
    {


        return $this->render('espace_client.html.twig');


    }

    public function log($message)
    {
        $this->logger->info($message);

    }

}