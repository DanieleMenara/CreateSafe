<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        //h1 on index should be 'CreateSafe'
        $this->assertContains('Copyright', $crawler->filter('h1')->text());
    }

    //test that the uploading of files is successful
    public function testUploading()
    {
    	$client = static::createClient();

        $client->request('GET', '/');

        //create dummy file
        $file = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(10, 10), $file);
		$photo = new UploadedFile(
            $file,
		    'someFile.jpg',
		    'image/jpeg',
		    123
		);

		$client->request('POST', '/_uploader/gallery/upload', array('file' => $photo), array(), array(
    		'HTTP_X-Requested-With' => 'XMLHttpRequest'
		));

		$this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testLoginRequiredBeforePayment() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Continue')->link();
        $client->click($link);

        //should be redirected to /login
        $loginUrl = $client->getContainer()->get('router')->generate('fos_user_security_login', [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL);
        $this->assertTrue($client->getResponse()->isRedirect($loginUrl));

        $crawler = $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());
        //should be redirected to /login where the h1 contains 'Sign in to continue.'
        $this->assertEquals('Sign in to continue', $crawler->filter('h1')->text());
    }


}
