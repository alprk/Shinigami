<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 12:25
 */

namespace App\Controller;


use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;
use App\Form\EmployeeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends Controller
{
    /**
     * Inscription d'un Utilisateur
     * @Route("/register", name="user_register",methods={"GET", "POST"})
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

}