<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $customer_nickname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $card_number;

    /**
     * @ORM\OneToOne(targetEntity="Customer", inversedBy="card", cascade={"persist"})
     * @ORM\JoinColumn(name="customer_id",referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="Score",mappedBy="card")
     */
    private $score;

    public function getId()
    {
        return $this->id;
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



    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    public function setCardNumber(string $card_number): self
    {
        $this->card_number = $card_number;

        return $this;
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

