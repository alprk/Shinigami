<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 14:30
 */

namespace App\Customer;


use App\Entity\Customer;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerManager
{
    private $manager;
    private $customerFactory;

    public function __construct(ObjectManager $manager,CustomerFactory $customerFactory)
    {
        $this->manager = $manager;
        $this->customerFactory = $customerFactory;
    }

    public function registerAsCustomer(CustomerRequest $customerRequest): Customer
    {
        # On appel notre Factory pour créer notre Objet Customer
        $customer = $this->customerFactory->createFromCustomerRequest($customerRequest);

        # On sauvegarde en BDD notre Customer
        $this->manager->persist($customer);
        $this->manager->flush();

        # On retourne le nouveau Customer
        return $customer;
    }

    public function update(CustomerRequest $customerRequest,Customer $customer): Customer
    {
        $customer = $this->customerFactory->updatefromcustomerrequest($customerRequest,$customer);
        $this->manager->persist($customer);
        $this->manager->flush();

        return $customer;
    }


}