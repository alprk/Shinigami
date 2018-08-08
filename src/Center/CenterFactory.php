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

        $center->setName($centerRequest->getName());
        $center->setCity($centerRequest->getCity());
        $center->setCode($centerRequest->getCode());
        $center->setCustomer(null);
        $center->setEmployee(null);

        return $center;
    }


    public function deletefromcenterrequest(CenterRequest $centerRequest,Center $center)
    {

    }

    public function updatefromcentererequest(CenterRequest $centerRequest, Center $center)
    {
        $center->setName($centerRequest->getName());
        $center->setCity($centerRequest->getCity());
        $center->setCode($centerRequest->getCode());

        return $center;
    }



}