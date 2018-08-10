<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/08/2018
 * Time: 16:01
 */

namespace App\Tests;

use App\Entity\Customer;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCustomerCanBeInstancied()
    {
        $this->assertInstanceOf(
            Customer::class,
            new Customer()
        );
    }

    public function testCustomerIsAnUser()
    {
        $this->assertInstanceOf(
            User::class,
            new Customer()
        );
    }
}