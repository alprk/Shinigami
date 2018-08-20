<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 14/08/2018
 * Time: 09:52
 */

namespace App\Tests\ControllerTests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Panther\PantherTestCase;

class SecurityControllerTest extends PantherTestCase
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

    public function testLoginAction()
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

        $h1WelcomeText = $crawler->filter('h1.welcomeUser')->text();

        $this->assertContains('BIENVENUE SUR LE SITE DU SHINIGAMI LASERGAME ADMIN', $h1WelcomeText);

    }

    public function testLogoutAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/deconnexion');

        $client->takeScreenshot('tests/screen/screenLoggedOutAdmin.jpg');

        $h1LoginText = $crawler->filter('h1.login')->text();

        $this->assertContains('CONNEXION', $h1LoginText);

    }

    public function testForgotPasswordAction()
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/forgot_password');

        $client->takeScreenshot('tests/screen/screenForgotPassword.jpg');

        $form = $crawler->selectButton('Valider')->form();

        $form['forgot_password[username]'] = 'Player';

        sleep(2);
        $crawler = $client->submit($form);

        $client->takeScreenshot('tests/screen/screenForgotPasswordSubmitted.jpg');

        $pSuccessText = $crawler->filter('p.success')->text();

        $this->assertContains('Un e-mail de réinitialisation de votre mot de passe vous a été envoyé!', $pSuccessText);

    }

    public function testResetPasswordAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/forgot_password');

        $form = $crawler->selectButton('Valider')->form();

        $form['forgot_password[username]'] = 'Player';

        sleep(2);

        // enables the profiler for the next request (it does nothing if the profiler is not available)
        $client->enableProfiler();

        $crawler = $client->submit($form);

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $messageBody = $message->getBody();

        $token = substr($messageBody, 131, 32);

        $crawler = $client->request('GET', '/reset_password?user='.$token);

        $form = $crawler->selectButton('Valider')->form();

        $form['reset_password[password][first]'] = 'newPwd';
        $form['reset_password[password][second]'] = 'newPwd';

        $crawler = $client->submit($form);

        $pSuccessText = $crawler->filter('p.success')->text();

        $this->assertContains('Votre mot de passe a bien été réinitialisé!', $pSuccessText);

    }
}