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
        $card = new Card();
        $card->setCustomer(null);
        $card->setCardNumber('11111');
        $card->setCustomerNickname('test');

        return $card;
    }


}