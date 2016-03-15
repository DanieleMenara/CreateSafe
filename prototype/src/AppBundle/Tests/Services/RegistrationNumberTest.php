<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Tests\FakeLogin;

class RegistrationNumberTest extends WebTestCase
{
    protected $container;
    protected $client;
    protected $mockUser;
    protected $generator;

    public function setUp() {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $mockToken = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\TokenInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->mockUser = $this->getMockBuilder('AppBundle\Entity\User')
            ->disableOriginalConstructor()
            ->getMock();
        $this->changeUsername();
        $mockToken->expects($this->any())->method('getUser')->will($this->returnValue($this->mockUser));
        $mockTokenStorage = $this->getMockBuilder('\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage')
            ->disableOriginalConstructor()
            ->getMock();
        $mockTokenStorage->expects($this->any())->method('getToken')->will($this->returnValue($mockToken));
        $this->generator = new \AppBundle\Services\HashingRegistrationNumber($mockTokenStorage);
    }

    private function changeUsername() {
        $newUsername = substr(uniqid(), 0, 5) . "@gmail.com";
        $this->mockUser->expects($this->any())->method('getUsername')->will($this->returnValue($newUsername));
    }

    public function testUniqueness() {
        $numbers = array();
        for($j = 0; $j<500; $j++) {
            for ($i = 0; $i < 25; $i++) {
                $registrationNumber = $this->generator->getUniqueRegistrationNumber();
                $this->assertNotContains($registrationNumber, $numbers);
                $numbers[] = $registrationNumber;
            }
            $this->changeUsername();
        }
    }
}