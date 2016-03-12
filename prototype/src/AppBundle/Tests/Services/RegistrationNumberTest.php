<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\FakeLogin;

class RegistrationNumberTest extends WebTestCase
{
    protected $container;
    protected $client;
    protected $user;
    protected $generator;

    public function setUp() {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $mockToken = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\TokenInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->user = FakeLogin::getUser($this->container);
        $mockToken->expects($this->any())->method('getUser')->will($this->returnValue($this->user));
        $mockTokenStorage = $this->getMockBuilder('\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage')
            ->disableOriginalConstructor()
            ->getMock();
        $mockTokenStorage->expects($this->any())->method('getToken')->will($this->returnValue($mockToken));
        $this->generator = new \AppBundle\Services\HashingRegistrationNumber($mockTokenStorage);
    }

    public function tearDown()
    {
        FakeLogin::removeUser($this->user, $this->container);
    }

    public function testUniqueness() {
        $numbers = array();
        for($i =0; $i<1000; $i++) {
            $registrationNumber = $this->generator->getUniqueRegistrationNumber();
            $this->assertNotContains($registrationNumber, $numbers);
            $numbers[] = $registrationNumber;
        }
    }
}