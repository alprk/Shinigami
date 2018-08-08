<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 14:13
 */

namespace App\Customer;

use App\Entity\Customer;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerRequest
{
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un nom d'utilisateur")
     */
    private $username;


    private $password;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un email")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un pseudo")
     */
    private $nickname;

    /**
     * @Assert\NotBlank(message="Veuillez saisir une adresse")
     */
    private $adress;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un numéro de téléphone")
     */
    private $phone;

    /**
     * @Assert\NotBlank(message="Veuillez saisir une date de naissance")
     */
    private $birthdate;

    private $roles;

    private $center;

    private $card;

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
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

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress): void
    {
        $this->adress = $adress;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @param Customer $customer
     * @return CustomerRequest
     */
    public static function createFromCustomer(Customer $customer): self
    {
        $cus = new self();
        $cus->id = $customer->getId();
        $cus->username = $customer->getUsername();
        $cus->nickname = $customer->getNickname();
        $cus->email = $customer->getEmail();
        $cus->adress = $customer->getAdress();
        $cus->phone = $customer->getPhone();
        $cus->birthdate = $customer->getBirthdate();
        $cus->center = $customer->getCenter();
        $cus->card = $customer->getCard();
        $cus->password = $customer->getPassword();
        return $cus;
    }

}