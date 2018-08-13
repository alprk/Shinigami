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
        $employee = $this->createConfiguredMock(Employee::class, [
            'getUsername' => 'test'
        ]);

        $employeerequest = $this->createConfiguredMock(EmployeeRequest::class, [
            'getUsername' => 'test'
        ]);

        $stub = $this->getMockBuilder(EmployeeFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $stub->method('createFromEmployeeRequest')
            ->willReturn($employee);


        $this->assertSame($employee, $stub->createFromEmployeeRequest($employeerequest));

        $this->assertSame($employee->getUsername(), $employeerequest->getUsername());
    }





}