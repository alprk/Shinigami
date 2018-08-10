<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/08/2018
 * Time: 16:22
 */

namespace App\Tests;


use Symfony\Component\Panther\PantherTestCase;

class CustomerControllerTest extends PantherTestCase
{
    public function testRegisterAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/register_customer');

        $client->takeScreenshot('screen.jpg');

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

        $client->takeScreenshot('screen.jpg');

        dump($client->getResponse());

        $divSuccessText = $crawler->filter('div.alert-success')->text();

        $this->assertContains('Félicitations, vous êtes maintenant inscrit !', $divSuccessText);

        //$this->assertEquals('Félicitations, vous êtes maintenant inscrit !', $divSuccessText);

        sleep(2);
    }

    public function testModifyInfoAction()
    {

        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('screen.jpg');

        $form = $crawler->selectButton('Connexion')->form();

        $form['app_login[username]'] = 'Toto';
        $form['app_login[password]'] = 'toto';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('screen.jpg');

        $link = $crawler->selectLink('Éditer mes informations')->link();

        $client->click($link);


        $client->takeScreenshot('screen.jpg');


    }
}