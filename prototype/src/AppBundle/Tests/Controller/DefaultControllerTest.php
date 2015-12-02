<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('CreateSafe', $crawler->filter('h1')->text());
    }

    //test that the uploading of files is successful
    public function testUploading()
    {
    	$client = static::createClient();

        $crawler = $client->request('GET', '/');
		
		//create dummy file
		$photo = new UploadedFile(
		    '/Users/daniele/Desktop/dan.jpg',
		    'dan.jpg',
		    'image/jpeg',
		    123
		);

		$crawler = $client->request('POST', '/_uploader/gallery/upload', array('file' => $photo), array(), array(
    		'HTTP_X-Requested-With' => 'XMLHttpRequest'
		));

		$this->assertTrue($client->getResponse()->isSuccessful());
    }
}
