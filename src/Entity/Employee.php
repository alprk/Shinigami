<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Center")
     * @ORM\JoinColumn(name="center_id",referencedColumnName="id")
     */
    private $center;


    public function getId()
    {
        return $this->id;
    }

    public function getCenter()
    {
        return $this->center;
    }

    public function setCenter($center): self
    {
        $this->center = $center;

        return $this;
    }
}
