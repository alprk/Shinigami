<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 15:59
 */

namespace App\Score;


use App\Entity\Card;
use App\Entity\Score;

class ScoreFactory
{
    public function createFromScoreRequest(ScoreRequest $request,Card $card,$value)
    {
        $score = new Score();
        $score->setCard($card);
        $score->setDate(new \DateTime());
        $score->setScoreValue($value);

        return $score;
    }
}