<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/08/2018
 * Time: 16:03
 */

namespace App\Score;


use App\Entity\Card;
use App\Entity\Score;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class ScoreManager
{
    private $manager;
    private $scoreFactory;
    private $em;


    public function __construct(ObjectManager $manager,ScoreFactory $scoreFactory, EntityManagerInterface $em)
    {
        $this->manager = $manager;
        $this->scoreFactory = $scoreFactory;
        $this->em = $em;
    }

    public function createScore(ScoreRequest $request,Card $card,$value): Score
    {
        # On appelle notre Factory pour créer notre Objet Score
        $score = $this->scoreFactory->createFromScoreRequest($request,$card,$value);

        # On sauvegarde en BDD notre Score
        $this->manager->persist($score);
        $this->manager->flush();

        # On retourne le nouveau Score
        return $score;
    }

    public function getScores($user){
        $em = $this->em;

        $card = $em->getRepository(Card::class)->findOneBy(
            array('customer' => $user)
        );

        $scores = $em->getRepository(Score::class)->findBy(
            array('card' => $card)
        );

        return $scores;
    }


}