<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 11:45
 */

namespace App\Employee;

use App\Entity\Employee;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EmployeeManager
{
    private $manager;
    private $employeeFactory;


    public function __construct(ObjectManager $manager, EmployeeFactory $employeeFactory)
    {
        $this->manager = $manager;
        $this->employeeFactory = $employeeFactory;

    }

    public function registerAsEmployee(EmployeeRequest $employeeRequest): Employee
    {
        # On appel notre Factory pour créer notre Objet User
        $employee = $this->employeeFactory->createFromEmployeeRequest($employeeRequest);

        # On sauvegarde en BDD notre User
        $this->manager->persist($employee);
        $this->manager->flush();

        # On retourne le nouvel utilisateur.
        return $employee;
    }

    public function deleteemployee()
    {

    }

}