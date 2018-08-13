<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 14:44
 */

namespace App\Tests\ManagerTests;


use App\Customer\CustomerFactory;
use App\Customer\CustomerManager;
use App\Customer\CustomerRequest;
use App\Entity\Customer;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerManagerTest extends TestCase
{
    private $manager;
    private $customerFactory;
    private $em;
    private $twig;
    private $mailer;
    private $encoder;
    private $flashBag;


    public function setUp()
    {
        $this->manager = $this->createMock(ObjectManager::class);
        $this->customerFactory = $this->createMock(CustomerFactory::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->twig = $this->createMock(\Twig_Environment::class);
        $this->mailer = $this->createMock(\Swift_Mailer::class);
        $this->encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->flashBag = $this->createMock(FlashBagInterface::class);
    }

    public function testmachin()
    {
        $customermanager = new customermanager($this->manager,$this->customerFactory,$this->em,$this->twig,$this->mailer,$this->encoder,$this->flashBag);

        $customerrequest = new CustomerRequest();
        $customerrequest->setUsername('blava');

        $customer = $customermanager->registerAsCustomer($customerrequest);

        $this->assertEquals('blava',$customer->getUsername());


    }


}