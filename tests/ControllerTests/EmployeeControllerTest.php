<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 10/08/2018
 * Time: 16:11
 */

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Panther\PantherTestCase;

class EmployeeControllerTest extends PantherTestCase
{
    public static function setUpBeforeClass()
    {
        $client = self::createClient();
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);
        $application->run(new StringInput('doctrine:database:drop --env=test --force'));
        $application->run(new StringInput('doctrine:database:create --env=test'));
        //$application->run(new StringInput('doctrine:schema:update --env=test --force'));
        $application->run(new StringInput('doctrine:migrations:migrate'));
        $application->run(new StringInput('doctrine:fixtures:load'));

    }

    public function testRegisterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/register_employee');

        $client->takeScreenshot('tests/screen/screenRegisterEmployee.jpg');

        $form = $crawler->selectButton('Créer l\'employé')->form();

        $form['employee[username]'] = 'Antoine';
        $form['employee[password]'] = 'antoine';
        $form['employee[email]'] = 'antoine.paliotti@gmail.com';
        $form['employee[center]'] = '1';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenEmployeeRegistered.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Compte créé !', $divSuccessText);

        sleep(2);
    }

    public function testAddCardAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('tests/screen/screenLogin.jpg');

        $form = $crawler->selectButton('Connexion')->form();

        $form['app_login[username]'] = 'Antoine';
        $form['app_login[password]'] = 'antoine';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenLoggedEmployee.jpg');

        $crawler = $client->request('GET', '/employee_add_card');

        $client->takeScreenshot('tests/screen/screenCardCreated.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Carte créée !', $divSuccessText);

        sleep(2);

    }

    public function testManageScoreAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/employee_manage_score');

        $client->takeScreenshot('tests/screen/screenManageScore.jpg');

        $form = $crawler->selectButton('Ajouter le score')->form();

        $form['modify_score[customer_id]'] = '1';
        $form['modify_score[score]'] = '3427';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenScoreAdded.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Score correctement rajouté !', $divSuccessText);
    }

    public function testListPlayersAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/employee_list_players');

        $client->takeScreenshot('tests/screen/screenListPlayers.jpg');

        $tableText = $crawler->filter('table td.username')->eq(0)->text();

        //dump($tableText);

        $this->assertContains('Player', $tableText);

    }

    public function testSearchPlayerAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/employee_search_player');

        $client->takeScreenshot('tests/screen/screenSearchPlayer.jpg');

        $form = $crawler->selectButton('Chercher')->form();

        $form['search_player[number]'] = '1114803112';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenPlayerFound.jpg');

        $tableText = $crawler->filter('table td.username')->eq(0)->text();

        //dump($tableText);

        $this->assertContains('Player', $tableText);

    }
}