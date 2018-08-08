<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 08/08/2018
 * Time: 12:02
 */

namespace App\Controller;

use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;
use App\Entity\Employee;
use App\Form\EmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
{
    /**
     * @Route("/administration", name="admin_management", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function admin_management()
    {
        return $this->render('administration.html.twig');

    }


    /**
     * @Route("/admin_card_management", name="admin_card_management", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function card_management()
    {
        return $this->render('administration.html.twig');

    }







    /**
     * @Route("/admin_employee_management", name="admin_employee_management", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function employee_management()
    {
        return $this->render('employeemanagement.html.twig');

    }

    /**
     * @Route("/admin_add_employee", name="admin_add_employee", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addemployee(Request $request,EmployeeManager $employeeManager)
    {

        $employeerequest = new EmployeeRequest();

        $form = $this->createForm(EmployeeType::class, $employeerequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $employee = $employeeManager->registerAsEmployee($employeerequest);

            return $this->render('employeemanagement.html.twig',[
                'success' => 'Employé créé'
            ]);


        }


        return $this->render('add_employee.html.twig',[
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/admin_list_employee", name="admin_list_employee", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listemployee(EntityManagerInterface $em)
    {
        $employees = $em->getRepository(Employee::class)->findAll();

        return $this->render('list_employee.html.twig',[
            'employees' => $employees
        ]);

    }






    /**
     * @Route("/admin_center_management", name="admin_center_management", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function center_management()
    {
        return $this->render('administration.html.twig');

    }



}