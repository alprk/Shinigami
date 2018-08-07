<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 14:20
 */

namespace App\Card;


class CardRequest
{
    private $id;


    private $customer_nickname;


    private $card_number;


    private $customer;


    private $score;

    /**
     * @return mixed
     */
    public function getCustomerNickname()
    {
        return $this->customer_nickname;
    }

    /**
     * @param mixed $customer_nickname
     */
    public function setCustomerNickname($customer_nickname): void
    {
        $this->customer_nickname = $customer_nickname;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number): void
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }



}