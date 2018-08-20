<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/08/2018
 * Time: 14:44
 */

namespace App\Tests\ManagerTests;


use App\Card\CardFactory;
use App\Card\CardManager;
use App\Card\CardRequest;

use App\Entity\Card;

use App\Entity\Customer;
use App\Repository\CardRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;


class CardManagerTest extends TestCase
{
    private $manager;
    private $cardFactory;
    private $em;


    public function setUp()
    {
        $card = new Card();

        $this->manager = $this->createMock(ObjectManager::class);
        $this->cardFactory = $this->createConfiguredMock(CardFactory::class,[
            'createFromCardRequest' => $card
        ]);

        $cardRepository = $this->createConfiguredMock(CardRepository::class,[
            'findByCode' => null
        ]);

        $this->em = $this->createConfiguredMock(EntityManagerInterface::class,[
            'getRepository' => $cardRepository
        ]);
    }

    public function testPersistAndFlushIsCalledOnCreate()
    {
        $cardManager = new CardManager($this->manager,$this->cardFactory,$this->em);

        $cardRequest = new CardRequest();

        $this->manager->expects($this->once())->method('persist');
        $this->manager->expects($this->once())->method('flush');

        $card = $cardManager->createCard($cardRequest,111);

    }

    public function testCardNumberIsCorrect()
    {
        $cardManager = new CardManager($this->manager,$this->cardFactory,$this->em);

        $cardRequest = new CardRequest();

        $card = $cardManager->createCard($cardRequest,111);

        $this->assertSame(substr($card->getCardNumber(), 0, 3),'111');

    }






}