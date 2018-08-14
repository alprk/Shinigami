<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 11:22
 */

namespace App\Tests\FactoryTests;


use App\Customer\CustomerFactory;
use App\Customer\CustomerManager;
use App\Customer\CustomerRequest;
use App\Employee\EmployeeFactory;
use App\Employee\EmployeeRequest;
use App\Entity\Center;
use App\Entity\Customer;
use App\Entity\Employee;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeFactoryTest extends TestCase

{

    public function testEmployeeRequestwillreturnEmployee()
    {
        $employeerequest = new EmployeeRequest();
        $employeerequest->setUsername('blava');


        $encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $employeefactory = new EmployeeFactory($encoder);

        $employee = $employeefactory->createFromEmployeeRequest($employeerequest);


        $this->assertSame($employee->getUsername(), $employeerequest->getUsername());

        $this->assertInstanceOf(Employee::class,$employee);
    }





}