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
        $encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $center = $this->createMock(Center::class);

        $customerrequest = new CustomerRequest();
        $customerrequest->setUsername('blava');
        $customerrequest->setEmail('blava@email.fr');
        $customerrequest->setAdress('blava address');
        $customerrequest->setPhone('0666965861');
        $customerrequest->setCenter($center);
        $customerrequest->setBirthdate(new \DateTime());
        $customerrequest->setNickname('blava');

        $customerfactory = new CustomerFactory($encoder,$em);

        $customer = $customerfactory->createFromCustomerRequest($customerrequest);

        $this->assertSame($customer->getUsername(),$customerrequest->getUsername());

        $this->assertInstanceOf(Customer::class,$customer);


    }

    public function testpasswordisencoded()
    {
        $encoder = $this->createConfiguredMock(UserPasswordEncoderInterface::class, [
            'encodePassword' => '&djhhte889402JJFUVFFZFZF4'
        ]);
        $em = $this->createMock(EntityManagerInterface::class);

        $center = $this->createMock(Center::class);

        $customerrequest = new CustomerRequest();
        $customerrequest->setUsername('blava');
        $customerrequest->setEmail('blava@email.fr');
        $customerrequest->setAdress('blava address');
        $customerrequest->setPhone('0666965861');
        $customerrequest->setCenter($center);
        $customerrequest->setBirthdate(new \DateTime());
        $customerrequest->setNickname('blava');

        $customerfactory = new CustomerFactory($encoder,$em);

        $customer = $customerfactory->createFromCustomerRequest($customerrequest);


        $this->assertSame('&djhhte889402JJFUVFFZFZF4', $customer->getPassword());
    }








}