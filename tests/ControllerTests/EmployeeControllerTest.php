<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 10/08/2018
 * Time: 16:11
 */

namespace App\Tests\ControllerTests;

use Symfony\Component\Panther\PantherTestCase;

class EmployeeControllerTest extends PantherTestCase
{
    public function testRegisterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/register_employee');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('Créer l\'employé')->form();

        $form['employee[username]'] = 'Antoine';
        $form['employee[password]'] = 'antoine';
        $form['employee[email]'] = 'antoine.paliotti@gmail.com';
        $form['employee[center]'] = '1';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Compte créé !', $divSuccessText);

        sleep(2);
    }

    public function testAddCardAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('Connexion')->form();

        $form['app_login[username]'] = 'Antoine';
        $form['app_login[password]'] = 'antoine';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $link = $crawler->selectLink('Créer une carte pour mon centre')->link();

        $crawler = $client->click($link);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Carte créée !', $divSuccessText);

        sleep(2);

    }

    public function testManageScoreAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/employee_manage_score');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('Ajouter le score')->form();

        $form['modify_score[customer_id]'] = '3';
        $form['modify_score[score]'] = '3427';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Score correctement rajouté !', $divSuccessText);
    }

    public function testListPlayersAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/employee_list_players');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $tableText = $crawler->filter('table td.username')->eq(0)->text();

        dump($tableText);

        $this->assertContains('Player', $tableText);

    }

    public function testSearchPlayerAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/employee_search_player');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('Chercher')->form();

        $form['search_player[number]'] = '1114803112';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $tableText = $crawler->filter('table td.username')->eq(0)->text();

        dump($tableText);

        $this->assertContains('Toto', $tableText);

    }
}