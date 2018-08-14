<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 11:22
 */

namespace App\Tests\FactoryTests;



use App\Employee\EmployeeFactory;
use App\Entity\Card;
use App\Entity\Score;
use App\Score\ScoreFactory;
use App\Score\ScoreRequest;
use PHPUnit\Framework\TestCase;


class ScoreFactoryTest extends TestCase

{

    public function testScoreRequestwillreturnScore()
    {
        $scorerequest = new ScoreRequest();
        $scorerequest->setScoreValue(99.0);

        $scorefactory = new ScoreFactory();

        $card = $this->createMock(Card::class);

        $score = $scorefactory->createFromScoreRequest($scorerequest,$card,$scorerequest->getScoreValue());



        $this->assertSame($score->getScoreValue(), $scorerequest->getScoreValue());

        $this->assertInstanceOf(Score::class,$score);
    }





}