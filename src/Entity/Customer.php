<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;


    /**
     * @ORM\ManyToOne(targetEntity="Center")
     * @ORM\JoinColumn(name="center_id",referencedColumnName="id")
     */
    private $center;

    /**
     * @ORM\OneToOne(targetEntity="Card", mappedBy="customer", cascade={"persist"} )
     * @ORM\JoinColumn(name="card_id",referencedColumnName="id")
     */
    private $card;

    public $encoder;

    /**
     * UserFactory constructor.
     * @param UserPasswordEncoderInterface $encoder
     */

    public function getId()
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     */
    public function setCard($card): void
    {
        $this->card = $card;
    }

    /**
     * @return mixed
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * @param mixed $center
     */
    public function setCenter($center): void
    {
        $this->center = $center;
    }



}
