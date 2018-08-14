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
        $customer = $this->createConfiguredMock(Customer::class, [
            'getUsername' => 'test',
            'getEmail' => 'test@email.fr'
        ]);


        $cardrequest = new CardRequest();

        $cardrequest->setCustomer($customer);

        $cardfactory = new CardFactory();


        $card = $cardfactory->createFromCardRequest($cardrequest);


        $this->assertSame($customer->getUsername(), $card->getCustomer()->getUsername());

        $this->assertInstanceOf(Card::class,$card);
    }





}