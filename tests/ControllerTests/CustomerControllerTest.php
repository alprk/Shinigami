<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/08/2018
 * Time: 16:22
 */

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Panther\PantherTestCase;

class CustomerControllerTest extends PantherTestCase
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

        $crawler = $client->request('GET', '/register_customer');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('S\'inscrire')->form();

        $form['customer[email]'] = 'emailvalide@gmail.com';
        $form['customer[username]'] = 'Toto';
        $form['customer[nickname]'] = 'TotoLeGrand';
        $form['customer[adress]'] = '3 rue le Grand';
        $form['customer[phone]'] = '0123457896';
        $form['customer[birthdate][year]'] = '1983';
        $form['customer[birthdate][month]'] = '5';
        $form['customer[birthdate][day]'] = '18';
        $form['customer[password]'] = 'toto';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Félicitations, vous êtes maintenant inscrit !', $divSuccessText);

        sleep(2);
    }

    public function testModifyInfoAction()
    {

        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('Connexion')->form();

        $form['app_login[username]'] = 'Toto';
        $form['app_login[password]'] = 'toto';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $link = $crawler->selectLink('Éditer mes informations')->link();

        $crawler = $client->click($link);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $form = $crawler->selectButton('Modifier mes Informations Personnelles')->form();

        $form['customer[email]'] = 'emailvalide2@gmail.com';
        $form['customer[username]'] = 'Toto';
        $form['customer[nickname]'] = 'TotoLeGrand';
        $form['customer[adress]'] = '3 rue le Grand';
        $form['customer[phone]'] = '0123457896';
        $form['customer[birthdate][year]'] = '1983';
        $form['customer[birthdate][month]'] = '5';
        $form['customer[birthdate][day]'] = '18';
        $form['customer[password]'] = 'toto';
        $form['customer[center]'] = '1';


        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screen.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Modifications enregistrées !', $divSuccessText);

        sleep(2);

    }

    public function testAttachCardAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/customer_attach_card');

        $client->takeScreenshot('tests/screen/screenTest.jpg');

        $form = $crawler->selectButton('Rattacher la carte')->form();

        $form['attach_card[card_number]'] = '1118255580';

        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenTest.jpg');

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Carte rattachée', $divSuccessText);

    }

    public function testShowScoresAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/customer_show_scores');

        $client->takeScreenshot('tests/screen/screenShowScores.jpg');

        $tableText = $crawler->filter('table td.scoreVal')->eq(0)->text();

        $this->assertContains('66', $tableText);
    }

    public function testEspaceClientAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/customer_espace_client');

        $client->takeScreenshot('tests/screen/screen.jpg');

        $aText = $crawler->filter('a.customer_attach_card')->text();

        $this->assertContains('Rattacher une carte à son compte', $aText);

    }
}