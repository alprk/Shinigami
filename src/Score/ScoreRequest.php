<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 15:54
 */

namespace App\Score;


class ScoreRequest
{
    private $id;


    private $date;

    private $score_value;

    private $card;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getScoreValue()
    {
        return $this->score_value;
    }

    /**
     * @param mixed $score_value
     */
    public function setScoreValue($score_value): void
    {
        $this->score_value = $score_value;
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     */
    public function setCard($card): void
    {
        $this->card = $card;
    }




}