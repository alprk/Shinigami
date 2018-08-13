<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 11:22
 */

namespace App\Tests\FactoryTests;





use App\Card\CardFactory;
use App\Card\CardRequest;
use App\Entity\Card;
use App\Entity\Customer;
use PHPUnit\Framework\TestCase;


class CardFactoryTest extends TestCase

{

    public function testCardRequestwillreturnCard()
    {
        $customer = $this->createMock(Customer::class);

        $card = $this->createConfiguredMock(Card::class, [
            'getCustomer' => $customer
        ]);

        $cardrequest = $this->createConfiguredMock(CardRequest::class, [
            'getCustomer' => $customer
        ]);

        $stub = $this->getMockBuilder(CardFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $stub->method('createFromCardRequest')
            ->willReturn($card);


        $this->assertSame($card, $stub->createFromCardRequest($cardrequest));

        $this->assertSame($card->getCustomer(), $cardrequest->getCustomer());
    }





}