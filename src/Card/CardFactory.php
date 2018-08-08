<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 14:20
 */

namespace App\Card;


use App\Entity\Card;

class CardFactory
{
    public function createFromCardRequest(CardRequest $cardRequest)
    {
        $customer = $cardRequest->getCustomer();
        $nickname = $cardRequest->getCustomerNickname();

        $card = new Card();

        $card->setCustomer($customer);
        $card->setCustomerNickname($nickname);

        return $card;
    }


}