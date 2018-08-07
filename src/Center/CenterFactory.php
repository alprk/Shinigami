<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 14:45
 */

namespace App\Center;

use App\Entity\Center;

class CenterFactory
{
    public function createfromCenterRequest(CenterRequest $centerRequest)
    {
        $center = new Center();

        $center->setName('LETEST');
        $center->setCity('LETEST');
        $center->setCode(125);
        $center->setCustomer(null);
        $center->setEmployee(null);

        return $center;
    }

}