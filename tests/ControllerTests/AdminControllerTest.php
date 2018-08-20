<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 13/08/2018
 * Time: 10:54
 */

namespace App\Tests\ControllerTests;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Panther\PantherTestCase;

class AdminControllerTest extends PantherTestCase
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

    public function testAddEmployeeAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('tests/screen/screenLogin.jpg');

        $form = $crawler->selectButton('Connexion')->form();

        $form['app_login[username]'] = 'Admin';
        $form['app_login[password]'] = 'admin';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenLoggedAdmin.jpg');

        $crawler = $client->request('GET', '/admin_add_employee');

        $form = $crawler->selectButton('Créer l\'employé')->form();

        $form['employee[username]'] = 'Titi';
        $form['employee[password]'] = 'titi';
        $form['employee[email]'] = 'titi@titi.com';
        $form['employee[center]' ] = '1';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenEmployeeCreated.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Employé créé !', $divSuccessText);

    }

    public function testListEmployeeAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_list_employee');

        $client->takeScreenshot('tests/screen/screenListEmployees.jpg');

        $tableText = $crawler->filter('table td.username')->eq(0)->text();

        //dump($tableText);

        $this->assertContains('Employee', $tableText);

    }

    public function testDeleteCenterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_center_delete');

        $client->takeScreenshot('tests/screen/screenCenterDelete.jpg');

        $form = $crawler->selectButton('Supprimer le centre')->form();

        $form['delete_center[center_id]'] = '4';

        sleep(2);
        $crawler = $client->submit($form);

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Votre centre à correctement été supprimé !', $divSuccessText);

    }

    public function testAddCenterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_add_center');

        $client->takeScreenshot('tests/screen/screenAddCenter.jpg');

        $form = $crawler->selectButton('Créer le centre')->form();

        $form['add_center[name]'] = 'Laser Test';
        $form['add_center[city]'] = 'Ville test';
        $form['add_center[code]'] = '999';

        sleep(2);
        $crawler = $client->submit($form);

        $divSuccessText = $crawler->filter('div.alert-success')->text();
        $this->assertContains('Votre centre à correctement été ajouté !', $divSuccessText);

    }

    public function testAddCardAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_add_card');

        $client->takeScreenshot('tests/screen/screenAddCard.jpg');

        $form = $crawler->selectButton('Créer les cartes')->form();

        $form['add_card[number]'] = '3';
        $form['add_card[center]'] = '1';

        sleep(2);
        $crawler = $client->submit($form);

        $divSuccessText = $crawler->filter('div.alert-success')->text();
        $this->assertContains('Cartes créées !', $divSuccessText);
    }

    public function testListCardsAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_list_card');

        $client->takeScreenshot('tests/screen/screenListCards.jpg');

        $tableText = $crawler->filter('table td.cardNumber')->eq(0)->text();

        //dump($tableText);

        $this->assertContains('1114803112', $tableText);

    }

    public function testModifyCenterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_modify_center');

        $client->takeScreenshot('tests/screen/screenModifyCenter.jpg');

        $form = $crawler->selectButton('Modifier le centre')->form();

        $form['add_center[center]'] = '1';
        $form['add_center[name]'] = 'LaserParadise';
        $form['add_center[city]'] = 'Rouen';
        $form['add_center[code]'] = '112';

        sleep(2);
        $crawler = $client->submit($form);

        $divSuccessText = $crawler->filter('div.alert-success')->text();
        $this->assertContains('Votre centre à correctement été modifié !', $divSuccessText);
    }

    public function testListCenterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/admin_list_center');

        $client->takeScreenshot('tests/screen/screenListCenter.jpg');

        $tableText = $crawler->filter('table td.centerName')->eq(0)->text();

        //dump($tableText);

        $this->assertContains('LaserParadise', $tableText);

    }

}