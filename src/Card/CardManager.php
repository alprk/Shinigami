<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/08/2018
 * Time: 14:20
 */

namespace App\Card;

use App\Entity\Card;
use Doctrine\Common\Persistence\ObjectManager;

class CardManager
{
    private $manager;
    private $cardFactory;


    public function __construct(ObjectManager $manager, CardFactory $cardFactory)
    {
        $this->manager = $manager;
        $this->CardFactory = $cardFactory;

    }

    public function createcard(CardRequest $cardRequest): Card
    {
        # On appel notre Factory pour créer notre Objet Card
        $card = $this->CardFactory->createFromCardRequest($cardRequest);

        # On sauvegarde en BDD notre User
        $this->manager->persist($card);
        $this->manager->flush();

        # On retourne le nouvel utilisateur.
        return $card;
    }

    public function deletecard()
    {

    }

}