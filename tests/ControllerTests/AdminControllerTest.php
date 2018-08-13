<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 13/08/2018
 * Time: 10:54
 */

namespace App\Tests\ControllerTests;


use Symfony\Component\Panther\PantherTestCase;

class AdminControllerTest extends PantherTestCase
{
    public function testAddEmployeeAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('tests/screen/screen2.jpg');

        $form = $crawler->selectButton('Connexion')->form();

        $form['app_login[username]'] = 'Admin';
        $form['app_login[password]'] = 'admin';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen3.jpg');

        $crawler = $client->request('GET', '/admin_add_employee');

        $form = $crawler->selectButton('Créer l\'employé')->form();

        $form['employee[username]'] = 'Titi';
        $form['employee[password]'] = 'titi';
        $form['employee[email]'] = 'titi@titi.com';
        $form['employee[center]' ] = '1';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen3.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Employé créé !', $divSuccessText);

    }

    public function testListEmployeeAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_list_employee');

        $client->takeScreenshot('tests/screen/screen3.jpg');

        $tableText = $crawler->filter('table td.username')->eq(0)->text();

        dump($tableText);

        $this->assertContains('Employee', $tableText);

    }

}