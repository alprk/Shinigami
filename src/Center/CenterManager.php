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
    private $centerFactory;

    public function __construct(ObjectManager $manager, CenterFactory $centerFactory)
    {
        $this->manager = $manager;
        $this->centerFactory = $centerFactory;

    }


    public function createCenter(CenterRequest $centerRequest): Center
    {
        $center = $this->centerFactory->createFromCenterRequest($centerRequest);

        $this->manager->persist($center);
        $this->manager->flush();

        return $center;

    }

    public function deleteCenter(Center $center)
    {
        $this->manager->remove($center);
        $this->manager->flush();
    }


    public function update(CenterRequest $centerRequest, Center $center)
    {
        $center = $this->centerFactory->updateFromCenterRequest($centerRequest,$center);
        $this->manager->persist($center);
        $this->manager->flush();
    }

}