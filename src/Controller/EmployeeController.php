<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 12:25
 */

namespace App\Controller;


use App\Card\CardManager;
use App\Card\CardRequest;
use App\Center\CenterManager;
use App\Center\CenterRequest;
use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;
use App\Entity\Customer;
use App\Form\EmployeeType;
use App\Form\ModifyScore;
use App\Score\ScoreManager;
use App\Score\ScoreRequest;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends Controller
{
    /**
     * Inscription d'un Utilisateur
     * @Route("/register_employee", name="employee_register",methods={"GET", "POST"})
     */
    public function register(Request $request, EmployeeManager $employeeManager)
    {
        $employee = new EmployeeRequest();

        $form = $this->createForm(EmployeeType::class, $employee)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Enregistrement de l'utilisateur
            $employee = $employeeManager->registerAsEmployee($employee);

            # Redirection
            return $this->redirectToRoute('index');
        }

        # Affichage du Formulaire dans la vue
        return $this->render('pol.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employee_add_card", name="employee_add_card", methods={"GET", "POST"})
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function addCard(CardManager $cardManager)
    {
        $cardRequest = new CardRequest();

        $employee = $this->getUser();

        $centerCode = $employee->getCenter()->getCode();

        $cardRequest->setCustomer(null);

        $cardRequest->setCustomerNickname(null);

        $card = $cardManager->createcard($cardRequest, $centerCode);

        return $this->render('index.html.twig',[
            'success' => 'Carte créée !'
        ]);
    }

    /**
     * Inscription d'un Utilisateur
     * @Route("/testcard", name="test_card",methods={"GET", "POST"})
     */
    public function testcard(CardManager $cardManager)
    {
        $cardRequest = new CardRequest();

        $employee = $this->getUser();

        $centerCode = $employee->getCenter()->getCode();

        $cardRequest->setCustomer(null);

        $cardRequest->setCustomerNickname(null);

        $card = $cardManager->createcard($cardRequest, $centerCode);

        return $this->redirectToRoute('index');
    }


    /**
     * Inscription d'un Utilisateur
     * @Route("/testcenter", name="test_center",methods={"GET", "POST"})
     */
    public function testcenter(CenterManager $centerManager)
    {
        $center = new CenterRequest();

        $card = $centerManager->createcenter($center);

        return $this->redirectToRoute('index');
    }

    /**
     * Inscription d'un Score
     * @Route("/testscore", name="test_score", methods={"GET", "POST"})
     */
    public function testscore(ScoreManager $scoreManager)
    {
        $scoreRequest = new ScoreRequest();

        $score = $scoreManager->createScore($scoreRequest);

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/customer_management", name="customer_management", methods={"GET", "POST"})
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function customer_management()
    {

        return $this->render('customer_management.html.twig');
    }




    /**
     * @Route("/employee_manage_score", name="employee_manage_score", methods={"GET", "POST"})
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function managescore(Request $request,ScoreManager $scoreManager)
    {
        $employee = $this->get('security.token_storage')->getToken()->getUser();

            $options = [
                'centerid' => $employee->getCenter()->getId()
            ];


        $form = $this->createForm(ModifyScore::class,null,$options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           $customer = $form->getData()['customer_id'];
           $value =  $form->getData()['score'];
           $card = $customer->getCard();

           if ($card)
           {
               $scorerequest = new ScoreRequest();

               $scoreManager->createScore($scorerequest,$card,$value);

               return $this->render('customer_management.html.twig',
                   [
                       'form' => $form->createView(),
                       'success' => 'Score correctement rajouté'
                   ]);

           }
           else
           {
               return $this->render('customer_management.html.twig',
                   [
                       'form' => $form->createView(),
                       'success' => 'Echec d\'ajout du score, le joueur n\'a pas encore rattaché de carte'
                   ]);

           }




        }

        return $this->render('employee_manage_score.html.twig',
            [
                'form' => $form->createView()
            ]);


    }



    /**
     * @Route("/employee_list_players", name="employee_list_players", methods={"GET", "POST"})
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function listPlayers(EntityManagerInterface $em)
    {
        $employee = $this->get('security.token_storage')->getToken()->getUser();

        $centerId = $employee->getCenter();

        $players = $em->getRepository(Customer::class)->findBy(
            array('center' => $centerId)
        );

        return $this->render('list_players_employee.html.twig',
            [
                'players' => $players
            ]);
    }

}