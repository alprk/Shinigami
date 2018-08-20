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

    public function testCenterRequestwillreturnCenter()
    {

        $centerrequest = new CenterRequest();
        $centerrequest->setName('blava');
        $centerrequest->setCity('blava');
        $centerrequest->setCode(149);

        $centerfactory = new CenterFactory();

        $center = $centerfactory->createFromCenterRequest($centerrequest);


        $this->assertSame($center->getName(),$centerrequest->getName());

        $this->assertInstanceOf(Center::class,$center);
    }






}