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
use App\Entity\Card;
use App\Entity\Center;
use App\Entity\Customer;
use App\Repository\CardRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerManagerTest extends TestCase
{
    /**
     * @var MockObject | ObjectManager
     */
    private $manager;
    private $customerFactory;
    private $em;
    private $twig;
    private $mailer;
    private $encoder;
    private $flashBag;


    public function setUp()
    {
        $center = new Center();
        $center->setCode(666);
        $customer = new Customer();
        $customer->setUsername('blava');
        $customer->setEmail('blava@email.fr');
        $customer->setAdress('blava address');
        $customer->setPhone('0666965861');
        $customer->setCenter($center);
        $customer->setBirthdate(new \DateTime());
        $customer->setNickname('blava');

        $card = new Card();
        $card->setCardNumber('666548796325');

        $customerRepository = $this->createConfiguredMock(CardRepository::class,[
            'findOneBy' => null,
            'find' => $customer,
            'findByCode' => $card
        ]);

        $this->manager = $this->createMock(ObjectManager::class);

         $this->customerFactory = $this->createConfiguredMock(CustomerFactory::class,[
            'createFromCustomerRequest' => $customer
        ]);
        $this->em = $this->createConfiguredMock(EntityManagerInterface::class,[
            'getRepository' => $customerRepository
        ]);
        $this->twig = $this->createMock(\Twig_Environment::class);
        $this->mailer = $this->createMock(\Swift_Mailer::class);
        $this->encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->flashBag = $this->createMock(FlashBagInterface::class);
    }

    public function testpersistandflushiscalledonregister()
    {
        $customermanager = new CustomerManager($this->manager,$this->customerFactory,$this->em,$this->twig,$this->mailer,$this->encoder,$this->flashBag);

        $customerrequest = new CustomerRequest();

        $this->manager->expects($this->once())->method('persist');
        $this->manager->expects($this->once())->method('flush');

        $customer = $customermanager->registerAsCustomer($customerrequest);

    }

    public function testCardCanBeAttachedToACustomer()
    {
        $customermanager = new CustomerManager($this->manager,$this->customerFactory,$this->em,$this->twig,$this->mailer,$this->encoder,$this->flashBag);

        $customerrequest = new CustomerRequest();

        $customer = $customermanager->registerAsCustomer($customerrequest);

        $customermanager->attachCard($customer,'666548796325');

        $this->assertSame($customer->getCard()->getCardNumber(),'666548796325');
    }





}