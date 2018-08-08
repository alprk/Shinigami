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
use App\Form\EmployeeType;
use App\Score\ScoreManager;
use App\Score\ScoreRequest;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

}