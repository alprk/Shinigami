<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 11:44
 */

namespace App\Employee;

use App\Entity\Employee;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeFactory
{
    private $encoder;

    /**
     * UserFactory constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function createFromEmployeeRequest(EmployeeRequest $request): Employee
    {
        $employee = new Employee();

        $employee->setUsername($request->getUsername());
        $employee->setPassword($this->encoder->encodePassword($employee, $request->getPassword()));
        $employee->setEmail($request->getEmail());
        $employee->setCenter($request->getCenter());
        $employee->setRoles(['ROLE_EMPLOYEE']);

        return $employee;
    }

}