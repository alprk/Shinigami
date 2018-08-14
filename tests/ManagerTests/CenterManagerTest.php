<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 14:44
 */

namespace App\Tests\ManagerTests;


use App\Center\CenterFactory;
use App\Center\CenterManager;
use App\Center\CenterRequest;

use App\Entity\Center;
use Doctrine\Common\Persistence\ObjectManager;

use PHPUnit\Framework\TestCase;


class CenterManagerTest extends TestCase
{
    private $manager;
    private $centerfactory;


    public function setUp()
    {
        $center = new Center;
        $center->setName('blava');

        $this->manager = $this->createMock(ObjectManager::class);
        $this->centerfactory = $this->createConfiguredMock(CenterFactory::class,[
            'createfromCenterRequest' => $center
        ]);
    }

    public function testpersistandflushiscalledoncreate()
    {
        $centermanager = new CenterManager($this->manager,$this->centerfactory);

        $centerrequest = new CenterRequest();

        $this->manager->expects($this->once())->method('persist');
        $this->manager->expects($this->once())->method('flush');

        $center = $centermanager->createcenter($centerrequest);

    }


}