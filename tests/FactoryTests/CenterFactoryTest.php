<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 11:22
 */

namespace App\Tests\FactoryTests;


use App\Center\CenterFactory;
use App\Center\CenterRequest;
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

class CenterFactoryTest extends TestCase

{

    public function testCustomerRequestwillreturnCustomer()
    {
        $center = $this->createConfiguredMock(Center::class, [
            'getName' => 'test'
        ]);

        $centerrequest = $this->createConfiguredMock(CenterRequest::class, [
            'getName' => 'test'
        ]);

        $stub = $this->getMockBuilder(CenterFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $stub->method('createfromCenterRequest')
            ->willReturn($center);


        $this->assertSame($center, $stub->createfromCenterRequest($centerrequest));

        $this->assertSame($center->getName(), $centerrequest->getName());
    }





}