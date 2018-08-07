<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 14:46
 */

namespace App\Center;


class CenterRequest
{

    private $id;
    /**
     * @Assert\NotBlank(message="Veuillez saisir un nom")
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Veuillez saisir une ville")
     */
    private $city;

    /**
     * @Assert\NotBlank(message="Veuillez saisir un code")
     */
    private $code;

    private $employee;

    private $customer;

}