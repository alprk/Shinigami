<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 14:22
 */

namespace App\Customer;


use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFactory
{
    private $encoder;
    private $em;

    /**
     * CustomerFactory constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
    }

    public function createFromCustomerRequest(CustomerRequest $request): Customer
    {
        $customer = new Customer();

        $customer->setUsername($request->getUsername());
        $customer->setPassword($this->encoder->encodePassword($customer, $request->getPassword()));
        $customer->setEmail($request->getEmail());
        $customer->setAdress($request->getAdress());
        $customer->setNickname($request->getNickname());
        $customer->setBirthdate($request->getBirthdate());
        $customer->setPhone($request->getPhone());
        $customer->setCenter($request->getCenter());
        $customer->setRoles(['ROLE_USER']);

        return $customer;
    }

    public function updatefromcustomerrequest(CustomerRequest $customerRequest,Customer $customer): Customer
    {
        $customer->setUsername($customerRequest->getUsername());
        $customer->setCenter($customerRequest->getCenter());
        $customer->setNickname($customerRequest->getNickname());
        $customer->setAdress($customerRequest->getAdress());
        $customer->setPhone($customerRequest->getPhone());
        $customer->setEmail($customerRequest->getEmail());
        $customer->setBirthdate($customerRequest->getBirthdate());

        if ($customerRequest->getPassword() !== null)
        {
            $customer->setPassword($this->encoder->encodePassword($customer, $customerRequest->getPassword()));
        }

        return $customer;
    }






}