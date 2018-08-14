<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 14:44
 */

namespace App\Tests\ManagerTests;



use App\Center\CenterManager;
use App\Center\CenterRequest;

use App\Entity\Card;
use App\Entity\Score;
use App\Score\ScoreFactory;
use App\Score\ScoreManager;
use App\Score\ScoreRequest;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;


class ScoreManagerTest extends TestCase
{

    private $manager;
    private $scoreFactory;
    private $em;


    public function setUp()
    {
        $score = new Score;
        $score->setScoreValue(66);

        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->manager = $this->createMock(ObjectManager::class);
        $this->scoreFactory = $this->createConfiguredMock(ScoreFactory::class,[
            'createFromScoreRequest' => $score
        ]);
    }

    public function testpersistandflushiscalledoncreate()
    {
        $scoremanager = new ScoreManager($this->manager,$this->scoreFactory,$this->em);
        $card = new Card();
        $scorerequest = new ScoreRequest();

        $this->manager->expects($this->once())->method('persist');
        $this->manager->expects($this->once())->method('flush');

        $center = $scoremanager->createScore($scorerequest,$card,66);

    }


}