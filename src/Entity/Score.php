<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreRepository")
 */
class Score
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $score_value;

    /**
     * @ORM\ManyToOne(targetEntity="Card")
     * @ORM\JoinColumn(name="card_id",referencedColumnName="id")
     */
    private $card;


    public function getId()
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getScoreValue(): ?float
    {
        return $this->score_value;
    }

    public function setScoreValue(float $score_value): self
    {
        $this->score_value = $score_value;

        return $this;
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
