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
use Doctrine\ORM\EntityManagerInterface;

class CardManager
{
    private $manager;
    private $cardFactory;
    private $em;


    public function __construct(ObjectManager $manager, CardFactory $cardFactory, EntityManagerInterface $em)
    {
        $this->manager = $manager;
        $this->cardFactory = $cardFactory;
        $this->em = $em;

    }

    public function createcard(CardRequest $cardRequest, $centerCode): Card
    {
        # On appel notre Factory pour créer notre Objet Card
        $card = $this->cardFactory->createFromCardRequest($cardRequest);

        $cardNumber = $this->generateCode($centerCode);
        $card->setCardNumber($cardNumber);

        # On sauvegarde en BDD notre User
        $this->manager->persist($card);
        $this->manager->flush();

        # On retourne le nouvel utilisateur.
        return $card;
    }

    public function deletecard()
    {

    }

    /**
     * Génération du code de la carte, à 10 chiffres
     * @param $centerCode CODE_CENTRE
     * @return string
     */
    public function generateCode($centerCode)
    {
        //Génération des 9 premiers chiffres de la carte
        //CODE_CENTRE + CODE_CARTE
        $cardCode = $this->generateCardCode();
        $code = $centerCode . $cardCode;

        //Génération du modulo
        //CHECKSUM
        $modulo = $this->checksum($code);

        //Code final
        $finalCode = $code . $modulo;

        //Vérification de l'unicité du code final
        if($this->checkCode($finalCode) === true){
            $this->generateCode($centerCode);
        }

        return $finalCode;
    }

    /**
     * Génération du CODE_CARTE
     * @return int
     */
    private function generateCardCode(){
        //Génère un nombre aléatoire entre 100000 et 999999, afin d'être certain d'obtenir un nombre à 6 chiffres
        return rand(100000, 999999);
    }

    /**
     * Génération du CHECKSUM
     * @param float $number CODE_CENTRE + CODE_CARTE
     * @return int
     */
    private function checksum(float $number){
        $sum = 0;

        // On convertit le code en tableau avec chaque caractère dedans
        $chars = str_split($number);

        //On parcourt caractère par caractère et on les somme
        foreach ($chars as $char) {
            $sum += $char;
        }

        //On obtient le CHECKSUM, en faisant la somme trouvée modulo 9
        $modulo = $sum % 9;

        return $modulo;
    }

    /**
     * Vérifie si le code existe ou pas en BDD
     * @param float $code
     * @return bool
     */
    private function checkCode(float $code){
        $exists = false;
        $repository = $this->em->getRepository(Card::class);

        // On cherche si le code existe en BDD
        $code = $repository->findByCode($code);

        //Si le code existe en BDD
        if ($code !== null) {
            $exists = true;
        }

        return $exists;
    }

    public function testgenerateCode($centerCode)
    {

        $finalCode = $centerCode;

        $repository = $this->em->getRepository(Card::class);

        $code = $repository->findByCode($finalCode);  /// implémenter findbycode().

        if ($code !== null) {
            $finalCode = $this->generateCode('444');
        }

        return $finalCode;
    }

}