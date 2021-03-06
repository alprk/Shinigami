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

use App\Card\CardManager;
use App\Card\CardRequest;

use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;
use App\Entity\Card;
use App\Entity\Center;
use App\Entity\Employee;

use App\Form\AddCenterType;
use App\Form\DeleteCenterType;

use App\Form\AddCardType;

use App\Form\EmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
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
        return $this->render('cardmanagement.html.twig');

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

            $this->addFlash('notice', 'Employé créé !');

            $this->log('Ajout de l\'employee '. $employee->getUsername() . ' par '.$this->getUser()->getUsername());


            return $this->render('employeemanagement.html.twig');


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
        $employees = $em->getRepository(Employee::class)->findAllEmployees();

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

        $form = $this->createForm(DeleteCenterType::class);

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
                $employeeManager->deleteEmployee($employee);
            }
            //
            $centerManager->deleteCenter($center);

            $this->addFlash('notice', 'Votre centre à correctement été supprimé !');

            $this->log('Suppression du centre '. $center->getName() . ' par '.$this->getUser()->getUsername());


            return $this->render('centermanagement.html.twig');
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
    public function addCenter(Request $request, CenterManager $centerManager)
    {
        $center = new CenterRequest();

        $form = $this->createForm(AddCenterType::class, $center);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $center = $centerManager->createCenter($center);
            $this->addFlash('notice', 'Votre centre à correctement été ajouté !');
            $this->log('Ajout du centre '. $center->getName() . ' par '.$this->getUser()->getUsername());

            return $this->render('centermanagement.html.twig');
        }

        return $this->render('add_center.html.twig', [
            'form' => $form->createView()
    ]);

    }

    /**
     * @Route("/admin_add_card", name="admin_add_card", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addCard(Request $request, CardManager $cardManager, EntityManagerInterface $em)
    {
        $cardRequest = new CardRequest();

        $form = $this->createForm(AddCardType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $test = $form->getData();


            $nbCards = $test['number'];
            $center = $em->getRepository(Center::class)->find($test['center']);

            $centerCode = $center->getCode();

            for ($i = 1; $i <= $nbCards; $i++) {
                $card = $cardManager->createCard($cardRequest, $centerCode);
            }
            $this->addFlash('notice', 'Cartes créées !');
            $this->log('Ajout de '. $nbCards .' cartes pour le centre '.$center->getName(). ' par '.$this->getUser()->getUsername());

            return $this->render('cardmanagement.html.twig');
        }

        return $this->render('add_card.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin_list_card", name="admin_list_card", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listCards(EntityManagerInterface $em)
    {
        $cards = $em->getRepository(Card::class)->findAll();

        return $this->render('list_cards.html.twig',[
            'cards' => $cards
        ]);
    }


    /**
     * @Route("/admin_modify_center", name="admin_modify_center", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function modifyCenter(Request $request, CenterManager $centerManager)
    {
        $centerRequest = new CenterRequest();

        $options = [
            'etat' => 'Modifier ses informations'
        ];

        $form = $this->createForm(AddCenterType::class,$centerRequest,$options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $center = $this->getDoctrine()->getRepository(Center::class)
                ->find($form->getData()->getCenter());

            $centerManager->update($centerRequest,$center);

            $this->addFlash('notice', 'Votre centre à correctement été modifié !');
            $this->log('Modification du centre '. $center->getName().  ' par '.$this->getUser()->getUsername());

            return $this->render('centermanagement.html.twig');
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


    public function log($message)
    {
        $this->logger->info($message);

    }

}