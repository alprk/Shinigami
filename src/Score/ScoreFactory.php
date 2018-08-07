<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 15:59
 */

namespace App\Score;


use App\Entity\Score;

class ScoreFactory
{
    public function createFromScoreRequest(ScoreRequest $request)
    {
        $score = new Score();
        $score->setCard(null);
        $score->setDate(new \DateTime());
        $score->setScoreValue('1428');

        return $score;
    }
}