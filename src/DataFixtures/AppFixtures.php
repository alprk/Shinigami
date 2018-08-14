<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 03/08/2018
 * Time: 12:41
 */

namespace App\DataFixtures;


use App\Entity\Card;
use App\Entity\Center;
use App\Entity\Customer;
use App\Entity\Employee;
use App\Entity\Score;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;    /**

 * UserFactory constructor.

 * @param UserPasswordEncoderInterface $encoder

 */

    public function __construct(UserPasswordEncoderInterface $encoder)

    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $center = new Center();
        $center->setName('LaserParadise');
        $center->setCity('Avignon');
        $center->setCode(111);


        $center2 = new Center();
        $center2->setName('LaserQuest');
        $center2->setCity('Cannes');
        $center2->setCode(951);


        $center3 = new Center();
        $center3->setName('LaserFight');
        $center3->setCity('Lyon');
        $center3->setCode(951);


        $center4 = new Center();
        $center4->setName('LaserWar');
        $center4->setCity('Rouen');
        $center4->setCode(444);



        $customer = new Customer();
        $customer->setUsername('Admin');
        $customer->setPassword($this->encoder->encodePassword($customer, 'admin'));
        $customer->setNickname('admin');
        $customer->setBirthdate(new \DateTime());
        $customer->setAdress('admin adress');
        $customer->setPhone('0122222222');
        $customer->setEmail('admin_email@email.com');
        $customer->setRoles(['ROLE_ADMIN']);
        $customer->setCenter($center);


        $customer2 = new Customer();
        $customer2->setUsername('Player');
        $customer2->setPassword($this->encoder->encodePassword($customer, 'player'));
        $customer2->setNickname('player');
        $customer2->setBirthdate(new \DateTime());
        $customer2->setAdress('player address');
        $customer2->setPhone('0122222222');
        $customer2->setEmail('player_email@email.com');
        $customer2->setRoles(['ROLE_USER']);
        $customer2->setCenter($center);
        $customer2->setToken('52ef8eac14c42c2293d7c65c990b50a652ef8eac14c42c2293d7c65c990b50a6');

        $employee = new Employee();
        $employee->setUsername('Employee');
        $employee->setPassword($this->encoder->encodePassword($employee, 'employee'));
        $employee->setEmail('employee_email@email.com');
        $employee->setRoles(['ROLE_EMPLOYEE']);
        $employee->setCenter($center);

        $card = new Card();
        $card->setCardNumber(1114803112);
        $card->setCustomer($customer2);
        $customer2->setCard($card);
        $card->setCustomerNickname($customer2->getNickname());

        $card2 = new Card();
        $card2->setCardNumber(1118255580);
        $card2->setCustomer(null);
        $card2->setCustomerNickname(null);



        $date1 = DateTime::createFromFormat('Y-m-d H:i:s', '2018-08-07 15:00:00');
        $date2 = DateTime::createFromFormat('Y-m-d H:i:s', '2018-08-09 17:30:00');

        $score = new Score();
        $score->setCard($card);
        $score->setScoreValue(66);
        $score->setDate($date1);

        $score2 = new Score();
        $score2->setCard($card);
        $score2->setScoreValue(99);
        $score2->setDate($date2);

        $score3 = new Score();
        $score3->setCard($card2);
        $score3->setScoreValue(66);
        $score3->setDate($date1);


        $manager->persist($center);
        $manager->persist($center2);
        $manager->persist($center3);
        $manager->persist($center4);
        $manager->persist($customer);
        $manager->persist($customer2);
        $manager->flush();

        $manager->persist($employee);
        $manager->persist($card);
        $manager->persist($card2);
        $manager->persist($score);
        $manager->persist($score2);
        $manager->persist($score3);

        $manager->flush();

    }


}