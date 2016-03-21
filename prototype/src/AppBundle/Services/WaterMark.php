<?php

namespace AppBundle\Services;

use FPDI;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WaterMark
{
	private $pathToFile = '';
	private $ext = '';
	private $serial = '';
	/**
	 * @var ContainerInterface
	 */
	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function setFile($pathToFile){
		$this->pathToFile = (string)filter_var($pathToFile);
		$this->ext = strtolower(pathinfo($this->pathToFile, PATHINFO_EXTENSION)); 
		$this->serial = pathinfo($this->pathToFile, PATHINFO_FILENAME);
	}

	public function marker($pathToFile = '') {
		if(!($pathToFile == '')) {
			$this->setFile($pathToFile);
		}
		//For images
		if($this->ext == 'jpg' || $this->ext == 'jpeg' || $this->ext == 'png'){
			$this->imageMarker();
		}

		//For documents
		elseif($this->ext == 'pdf' || $this->ext == 'docx'){
			if($this->ext == 'pdf'){
				$this->pdfMarker();
			}

		}
		else {
			throw new Exception($pathToFile);
		}
	}

	public function imageMarker(){
		if($this->pathToFile == '') {
			return;
		}
		if ($this->ext == 'jpg' || $this->ext == 'jpeg' || $this->ext == 'png'){
			$image = new \Imagick;
			$image->readImage($this->pathToFile);

			$fontSize = 50;	//Size of the font

			$draw = new \ImagickDraw();
			$draw->setFillColor("rgb(85, 196, 241)");	//The same colour as the logo of createsafe.
			$draw->setFont($this->container->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('fonts/futura.ttf'));
			$draw->setFontSize($fontSize);

			$watermark = new \Imagick();
			$watermark->readImage($this->container->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('images/logo/watermark.png'));	//The file location might be changed in the future

			$imWidth = $image->getImageWidth();
			$imHeight= $image->getImageHeight();
			$wmWidth = $watermark->getImageWidth();
			$wmHeight = $watermark->getImageHeight();

			$x_WM = ($imWidth - $wmWidth);
			$y_WM = (($imHeight - $wmHeight) / 2);

			$x_AN = $x_WM + ($wmWidth / 4);
			$y_AN = (($imHeight + $wmHeight ) / 2 + 60);

			//Composition of a watermark logo.
			$image->compositeImage($watermark, \imagick::COMPOSITE_OVER, $x_WM, $y_WM);

            //set image compression
            $image->setImageCompressionQuality(20);

			//Annotation including serial number
			$image->annotateImage($draw, $x_AN, $y_AN, 0, $this->serial);

			$image->setImageFormat('png');
			header("Content-Type: image/png");
			$image->writeImage($this->pathToFile);
		}
		/*
		else {
			echo "Error";
		}
		*/
	}

	public function pdfMarker() {
		if($this->pathToFile == '') {
			return;
		}
		if ($this->ext == 'pdf'){
			$pdf = new FPDI();
			$pageCount = $pdf->setSourceFile($this->pathToFile);

			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    
    			// import a page
 		   		$templateId = $pdf->importPage($pageNo);
 		   		// get the size of the imported page
 			   	$size = $pdf->getTemplateSize($templateId);

 			   	// create a page (landscape or portrait depending on the imported page size)
 			   	if ($size['w'] > $size['h']) {
   			     	$pdf->AddPage('L', array($size['w'], $size['h']));
  				} 
  				else {
        			$pdf->AddPage('P', array($size['w'], $size['h']));
    			}

    			// use the imported page
    			$pdf->useTemplate($templateId);

			    $x = $size['w'] / 1.7;
				$y = $size['h'] / 4;

			    $pdf->Image($this->container->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('images/logo/watermark.png'), $x, $y, 80, '', '', '', '', false, '');

			    $pdf->SetFont('Arial', '', 16);
			    $pdf->SetTextColor(85, 196, 241);
			    $pdf->SetXY($x+10, $y+120);
		 		$pdf->Write(1, $this->serial);
			}
			$pdf->Output($this->pathToFile, 'F');

			//create image preview of first page for visualisation purposes.
			$firstpage = $this->pathToFile.'[0]';
			$image = new \Imagick($firstpage);
			$image->setResolution( 300, 300 );
			$image->setImageFormat( "png" );
			header("Content-Type: image/png");
			$image->writeImage(pathinfo($this->pathToFile, PATHINFO_DIRNAME).'/'.$this->serial.'.png');
		}
	}



}

/*
$a = new WaterMark();
$a->setFilePath(dirname(__FILE__) . '/resource/Math.pdf');

$b = new WaterMark();
$b->setFilePath(dirname(__FILE__) . '/resource/dog.png');

$c = new Watermark();
$c->setFilePath(dirname(__FILE__) . '/resource/dog.jpg');


$a->marker();		//For pdf format
$b->marker();		//For png format
$c->marker();		//For jpg format
*/

