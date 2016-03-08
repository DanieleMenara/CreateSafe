<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Finder\Iterator\FileTypeFilterIterator;
use AppBundle\Tests\FakeLogin;


class BaseUserTest extends WebTestCase
{
    protected $client;
    protected $container;
    protected $user;

    public function setUp() {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->user = FakeLogin::getUser($this->container);
        FakeLogin::logIn($this->client, $this->container, $this->user);
    }

    //remove test user from database
    public function tearDown() {
        FakeLogin::removeUser($this->user, $this->container);
    }

    //need some files uploaded in order to be able to access the payment page.
    private function uploadFakeFile() {
        $mockManager = $this->getMockBuilder('Oneup\UploaderBundle\Uploader\Storage\FilesystemOrphanageStorage')
            ->disableOriginalConstructor()
            ->getMock();
        $file = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(10, 10), $file);
        $photo = new UploadedFile(
            $file,
            'someFile.jpg',
            'image/jpeg',
            123
        );
        $mockIterator = new FileTypeFilterIterator(new ArrayIterator(array($photo)), FileTypeFilterIterator::ONLY_FILES);
        $mockManager->expects($this->any())->method('getFiles')->will($this->returnValue($mockIterator));
        $mockOrphanage = $this->getMockBuilder('Oneup\UploaderBundle\Uploader\Orphanage\OrphanageManager')->disableOriginalConstructor()->getMock();
        $mockOrphanage->expects($this->any())->method('get')->with('gallery')->will($this->returnValue($mockManager));
        $this->client->getContainer()->set('oneup_uploader.orphanage_manager', $mockOrphanage);
    }

    /**
     * When trying to access the payment page without any uploads, should be redirected to the Homepage
     */
    public function testPaymentRequireUploads() {
        $this->client->request('GET', '/payment');
        $homepageUrl = $this->client->getContainer()->get('router')->generate('homepage', [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH);
        $this->assertTrue($this->client->getResponse()->isRedirect($homepageUrl));
    }

    /**
     * Test that when logged in and with files uploaded the payment page is successfully loaded.
     */
    public function testPaymentPageLoaded() {
        $this->uploadFakeFile();
        $crawler = $this->client->request('GET', '/payment');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals('Your order summary', $crawler->filter('h1')->text());
    }
}