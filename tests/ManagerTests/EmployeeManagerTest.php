<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 14:44
 */

namespace App\Tests\ManagerTests;



use App\Employee\EmployeeFactory;
use App\Employee\EmployeeManager;
use App\Employee\EmployeeRequest;

use App\Entity\Employee;
use Doctrine\Common\Persistence\ObjectManager;

use PHPUnit\Framework\TestCase;


class EmployeeManagerTest extends TestCase
{
    private $manager;
    private $employeeFactory;


    public function setUp()
    {
        $employee = new Employee();
        $employee->setUsername('blava');

       $this->manager = $this->createMock(ObjectManager::class);
       $this->employeeFactory = $this->createConfiguredMock(EmployeeFactory::class,[
           'createFromEmployeeRequest' => $employee
       ]);
    }

    public function testpersistandflushiscalledonregister()
    {
        $employeemanager = new EmployeeManager($this->manager,$this->employeeFactory);

        $employeerequest = new EmployeeRequest();


        $this->manager->expects($this->once())->method('persist');
        $this->manager->expects($this->once())->method('flush');

        $employee = $employeemanager->registerAsEmployee($employeerequest);

    }


}