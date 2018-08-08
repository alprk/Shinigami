<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 08/08/2018
 * Time: 12:02
 */

namespace App\Controller;

use App\Center\CenterManager;
use App\Center\CenterRequest;
use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;
use App\Entity\Card;
use App\Entity\Center;
use App\Entity\Employee;
use App\Form\AddCenter;
use App\Form\DeleteCenter;
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
     * @Route("/admin_center_delete", name="admin_delete_center", methods={"GET","POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete_center(Request $request, CenterManager $centerManager,EmployeeManager $employeeManager)
    {

        $form = $this->createForm(DeleteCenter::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $center = $this->getDoctrine()
                ->getRepository(Center::class)
                ->find($form->getData()['center_id']);

            // Employees of the center are deleted too
            $employees = $this->getDoctrine()->getRepository(Employee::class)->findBy(
                array('center' => $center)
            );

            foreach ($employees as $employee)
            {
                $employeeManager->deleteemployee($employee);
            }
            //
            $centerManager->deletecenter($center);

            return $this->render('centermanagement.html.twig',[
                'succes' => 'Votre centre à correctement été supprimé !'

            ]);
        }


        return $this->render('delete_center.html.twig',[
            'form' => $form->createView()
        ]);

    }






    /**
     * @Route("/admin_center_management", name="admin_center_management", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function center_management()
    {
        return $this->render('centermanagement.html.twig');

    }

    /**
     * @Route("/admin_add_center", name="admin_add_center", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addcenter(Request $request, CenterManager $centerManager)
    {
        $center = new CenterRequest();

        $form = $this->createForm(AddCenter::class, $center);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $center = $centerManager->createcenter($center);


            return $this->render('centermanagement.html.twig',[
                'succes' => 'Votre centre à correctement été ajouté !'

            ]);
        }

        return $this->render('add_center.html.twig',[
            'form' => $form->createView()
        ]);


    }


    /**
     * @Route("/admin_modify_center", name="admin_modify_center", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function modifycenter(Request $request, CenterManager $centerManager)
    {
        $centerrequest = new CenterRequest();

        $options = [
            'etat' => 'Modifier ses informations'
        ];

        $form = $this->createForm(AddCenter::class,$centerrequest,$options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $center = $this->getDoctrine()->getRepository(Center::class)
                ->find($form->getData()->getCenter());

            $centerManager->update($centerrequest,$center);


            return $this->render('centermanagement.html.twig',[
                'succes' => 'Votre centre à correctement été modifié !'

            ]);
        }

        return $this->render('modify_center.html.twig',[
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/admin_list_center", name="admin_list_center", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listCenter(EntityManagerInterface $em)
    {
        $centers = $em->getRepository(Center::class)->findAll();

        return $this->render('list_center.html.twig', [
            'centers' => $centers
        ]);
    }

}