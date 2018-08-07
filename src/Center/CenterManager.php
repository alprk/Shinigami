<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 14:46
 */

namespace App\Center;


use App\Entity\Center;
use Doctrine\Common\Persistence\ObjectManager;

class CenterManager
{
    private $manager;
    private $centerfactory;

    public function __construct(ObjectManager $manager, CenterFactory $centerFactory)
    {
        $this->manager = $manager;
        $this->centerfactory = $centerFactory;

    }


    public function createcenter(CenterRequest $centerRequest): Center
    {
        $center = $this->centerfactory->createfromCenterRequest($centerRequest);

        $this->manager->persist($center);
        $this->manager->flush();

        return $center;

    }

}