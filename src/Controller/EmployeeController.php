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
use App\Entity\Card;
use App\Entity\Customer;
use App\Form\EmployeeType;
use App\Form\ModifyScore;
use App\Form\SearchPlayerType;
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
     * Inscription d'un Employee
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

            $this->addFlash('notice', 'Compte créé !');

            # Redirection
            return $this->redirectToRoute('index');
        }

        # Affichage du Formulaire dans la vue
        return $this->render('registration.html.twig', [
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
        $this->addFlash('notice', 'Carte créée !');

        return $this->render('index.html.twig');
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

               $this->addFlash('notice', 'Score correctement rajouté !');

               return $this->render('customer_management.html.twig',
                   [
                       'form' => $form->createView(),

                   ]);

           }
           else
           {
               $this->addFlash('danger', 'Echec d\'ajout du score, le joueur n\'a pas encore rattaché de carte');

               return $this->render('customer_management.html.twig',
                   [
                       'form' => $form->createView()
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

        $employee = $this->getUser();

        $center = $employee->getCenter();

        $players = $em->getRepository(Customer::class)->findBy(
            array('center' => $center)
        );

        return $this->render('list_players_employee.html.twig',
            [
                'players' => $players
            ]);
    }


    /**
     * @Route("/employee_search_player", name="employee_search_player", methods={"GET", "POST"})
     * @Security("has_role('ROLE_EMPLOYEE')")
     */
    public function searchPlayer(EntityManagerInterface $em,Request $request)
    {
        $form = $this->createForm(SearchPlayerType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $playerrequest = $form->getData();

            $number = $playerrequest['number'];

            $card = $em->getRepository(Card::class)->findOneBy(
                array('card_number' => $number)
            );

            if ($card)
            {
                $player = $card->getCustomer();


                # Redirection
                return $this->render('display_search_result.html.twig',[
                    'player' => $player
                ]);

            }
            else
            {
                $this->addFlash('danger', 'Numéro incorrect !');

                return $this->render('employee_search_player.html.twig', [
                    'form' => $form->createView()
                ]);
            }


        }

        return $this->render('employee_search_player.html.twig', [
            'form' => $form->createView()
        ]);

    }

}