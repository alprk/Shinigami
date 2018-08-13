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
use App\Entity\Center;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFactoryTest extends TestCase

{

    public function testCustomerRequestwillreturnCustomer()
    {
        $customer = $this->createConfiguredMock(Customer::class, [
            'getUsername' => 'test'
        ]);

        $customerrequest = $this->createConfiguredMock(CustomerRequest::class, [
            'getUsername' => 'test'
        ]);

        $stub = $this->getMockBuilder(CustomerFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $stub->method('createFromCustomerRequest')
            ->willReturn($customer);


        $this->assertSame($customer, $stub->createFromCustomerRequest($customerrequest));

        $this->assertSame($customer->getUsername(), $customerrequest->getUsername());
    }





}