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

    public function updatefromemployeerequest(EmployeeRequest $employeeRequest, Employee $employee)
    {
        $employee->setUsername($employeeRequest->getUsername());
        $employee->setEmail($employeeRequest->getEmail());
        $employee->setCenter($employeeRequest->getCenter());

        if ($employeeRequest->getPassword() !== null)
        {
            $employee->setPassword($this->encoder->encodePassword($employee, $employeeRequest->getPassword()));
        }

        return $employee;
    }


}