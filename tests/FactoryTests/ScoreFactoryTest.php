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
        $score = $this->createConfiguredMock(Score::class, [
            'getScoreValue' => 99.0
        ]);

        $scorerequest = $this->createConfiguredMock(ScoreRequest::class, [
            'getScoreValue' => 99.0
        ]);

        $card = $this->createMock(Card::class);

        $stub = $this->getMockBuilder(ScoreFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $stub->method('createFromScoreRequest')
            ->willReturn($score);


        $this->assertSame($score, $stub->createFromScoreRequest($scorerequest,$card,$scorerequest->getScoreValue()));

        $this->assertSame($score->getScoreValue(), $scorerequest->getScoreValue());
    }





}