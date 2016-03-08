<?php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\User;
use AppBundle\Tests\FakeLogin;

class LoginAndRegistrationTest extends WebTestCase {
    protected $container;
    protected $client;

    public function setUp() {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
    }

    /**
     * Test successful Login
     */
    public function testLogin() {
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $user = FakeLogin::getUser($this->container);
        $form = $crawler->selectButton('Login')->form(array('_username' => 'user@test.test', '_password' => 'user'));
        $this->client->submit($form);

        $homepageUrl = $this->container->get('router')->generate('homepage', [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL);
        $this->assertTrue($this->client->getResponse()->isRedirect($homepageUrl));

        $crawler = $this->client->followRedirect();
        $this->assertContains('Copyright', $crawler->filter('h1')->text());
        FakeLogin::removeUser($user, $this->container);
    }

    /**
     * Test that trying to Login with Invalid credentials displays alert.
     */
    public function testLoginInvalidCredentials() {
        $crawler = $this->client->request('GET', '/login');

        //user has not been created. Should fail.
        $form = $crawler->selectButton('Login')->form(array('_username' => 'user@test.test', '_password' => 'user'));
        $this->client->submit($form);

        $loginUrl = $this->container->get('router')->generate('fos_user_security_login', [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL);
        $this->assertTrue($this->client->getResponse()->isRedirect($loginUrl));

        $crawler = $this->client->followRedirect();
        $this->assertContains('Invalid credentials.', $crawler->filter('.alert')->children()->filter('p')->text());
    }

    /**
     * Test successful registration
     */
    public function testRegistration() {
        $crawler = $this->client->request('GET', '/register/');
        $form = $crawler->selectButton('Register')->form();
        $values = $form->getValues();
        $values["fos_user_registration_form[email]"] = 'user@test.test';
        $values["fos_user_registration_form[plainPassword][first]"] = 'user';
        $values["fos_user_registration_form[plainPassword][second]"] ='user';
        $values["fos_user_registration_form[firstName]"] = 'First';
        $values["fos_user_registration_form[lastName]"] = 'Last';
        $form->setValues($values);
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $user = FakeLogin::getUser($this->container);
        FakeLogin::removeUser($user, $this->container);
    }
}