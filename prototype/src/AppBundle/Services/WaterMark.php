<?php

namespace AppBundle\Services;

use Doc2PdfConverter;
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
			$this->makeImageOfCertification();
			$this->imageMarker();
		}

		//For documents
		elseif($this->ext == 'pdf' || $this->ext == 'docx'){
			if($this->ext == 'pdf'){
				//$this->makeImageOfCertification();
				$this->pdfMarker();
			}
			
			elseif($this->ext == 'docx'){
				$this->docxConversion();
			}
			
		}
		else {
			throw new Exception($pathToFile);
		}
	}



	public function makeImageOfCertification(){
		date_default_timezone_set('UTC');
		$timeStamp = date('jS F Y');

		$text = "CERTIFIED COPY" . "\n" . ($this->serial) . "\n" . ($timeStamp);

		$image = new \Imagick();
		$draw = new \ImagickDraw();
		$color = new \ImagickPixel('#000000');
		$background = new \ImagickPixel("rgb(85, 196, 241)");

		$draw->setFont($this->container->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('fonts/futura.ttf'));
		$draw->setFontSize(24);
		$draw->setFillColor($color);
		$draw->setTextAntialias(true);
		$draw->setStrokeAntialias(true);

		//Align text to the center of the background
		$draw->setTextAlignment(\Imagick::ALIGN_CENTER);

		//Get information of annotation image
		$metrics = $image->queryFontMetrics($draw, $text);

		//Calc the distance(pixels) to move the sentences
		$move = $metrics['textWidth'] / 2;
		$draw->annotation($move, $metrics['ascender'], $text);

		//Create an image of certification
		$image->newImage($metrics['textWidth'], $metrics['textHeight'], $background);
		$image->setImageFormat('png');
		$image->drawImage($draw);

		//Save an image temporary
		$image->writeImage("cert_" . ($this->serial) . "_.png");
	}



	public function imageMarker(){
		if($this->pathToFile == '') {
			return;
		}
		if ($this->ext == 'jpg' || $this->ext == 'jpeg' || $this->ext == 'png'){
			$image = new \Imagick();
			$image->readImage($this->pathToFile);

			$cert = new \Imagick();
			$cert->readImage('cert_' . ($this->serial) . '_.png');

			$watermark = new \Imagick();
			$watermark->readImage($this->container->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('images/logo/watermark.png'));	//The file location might be changed in the future

			$imWidth = $image->getImageWidth();
			$imHeight= $image->getImageHeight();
			
			if ($imWidth > $imHeight){	// X > Y
				$size = $imHeight / 3;
				//Change logo size to (fit) * Y/3
				$watermark->resizeImage(0, $size, \Imagick::FILTER_POINT, 0);
				//Get the width of watermark after resizing
				$wmWidth = $watermark->getImageWidth();

				//Change certification size to $wmWidth * (fit)
				$cert->resizeImage($wmWidth, 0, \Imagick::FILTER_POINT, 0);

				//Composition
				$image->compositeImage($watermark, \imagick::COMPOSITE_OVER, ($imWidth - $size), $size);
				$image->compositeImage($cert, \imagick::COMPOSITE_OVER, ($imWidth - $size), 2 * $size);
				$image->setImageCompressionQuality(20);
				$image->setImageFormat('png');
				header("Content-Type: image/png");
				$image->writeImage($this->pathToFile);
				unlink('cert_' . ($this->serial) . '_.png');
			}

			elseif($imWidth <= $imHeight){	// X <= Y
				$size = $imWidth / 3;
				$watermark->resizeImage(0, $size, \Imagick::FILTER_POINT, 0);
				$wmWidth = $watermark->getImageWidth();

				$cert->resizeImage($wmWidth, 0, \Imagick::FILTER_POINT, 0);

				$image->compositeImage($watermark, \imagick::COMPOSITE_OVER, ($imWidth - $size), ($imHeight - $size)/2);
				$image->compositeImage($cert, \imagick::COMPOSITE_OVER, ($imWidth - $size), ($imHeight + $size)/2);
				$image->setImageCompressionQuality(20);
				$image->setImageFormat('png');
				header("Content-Type: image/png");
				$image->writeImage($this->pathToFile);
				unlink('cert_' . ($this->serial) . '_.png');
			}

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

			date_default_timezone_set('UTC');
			$timeStamp = date('jS F Y');

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

    			if($size['w'] > $size['h']){	//X > Y

    			}

    			elseif($size['w'] <= $size['h']){	//X <= Y
    				$sizeOfWM = $size['w'] / 3;

    			}

			    $x = $size['w'] / 1.7;
				$y = $size['h'] / 4;

			    $pdf->Image($this->container->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('images/logo/watermark.png'), $x, $y, 80, '', '', '', '', false, '');

			    $pdf->SetFillColor(85, 196, 241);
			    $pdf->SetTextColor('BLACK');
			    $pdf->SetFont('Arial', '', 16);
			    //$pdf->SetXY($x+10, $y+120);
			    $pdf->SetXY($x, $y+120);
		 		//$pdf->Write(1, $this->serial);
		 		$pdf->MultiCell(80, 15, "CERTIFIED COPY" . "\n" . $this->serial . "\n" . $timeStamp, 0, 'C', 1);
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

	
	public function docxConversion() {
		if($this->pathToFile == '') {
			return;
		}
		if($this->ext == 'docx') {
			require_once "PdfaidServices.php";
			$myDoc2Pdf = new \Doc2PdfConverter();
			$myDoc2Pdf->apiKey = "zwmvgzux2wnjjw";
			$myDoc2Pdf->inputDocLocation = $this->pathToFile;
			$myDoc2Pdf->outputPdfLocation = (dirname($this->pathToFile)) . "/" . ($this->serial) . ".pdf";//($this->serial) . '.pdf';
			$result = $myDoc2Pdf->Doc2PdfConvert();


			$pdf = new FPDI();
			$pageCount = $pdf->setSourceFile((dirname($this->pathToFile)) . "/" . ($this->serial) . ".pdf");

			date_default_timezone_set('UTC');
			$timeStamp = date('jS F Y');

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

			    $pdf->SetFillColor(85, 196, 241);
			    $pdf->SetTextColor('BLACK');
			    $pdf->SetFont('Arial', '', 16);
			    //$pdf->SetXY($x+10, $y+120);
			    $pdf->SetXY($x, $y+120);
		 		//$pdf->Write(1, $this->serial);
		 		$pdf->MultiCell(80, 15, "CERTIFIED COPY" . "\n" . $this->serial . "\n" . $timeStamp, 0, 'C', 1);
			}
			$pdf->Output(dirname($this->pathToFile) . '/' . ($this->serial) . '.pdf', 'F');

			//create image preview of first page for visualisation purposes.
			//$firstpage = $this->pathToFile.'[0]';
			$firstpage = dirname($this->pathToFile) . '/' . ($this->serial) . '.pdf[0]';
			$image = new \Imagick($firstpage);
			$image->setResolution( 300, 300 );
			$image->setImageFormat( "png" );
			header("Content-Type: image/png");
			$image->writeImage(pathinfo($this->pathToFile, PATHINFO_DIRNAME).'/'.$this->serial.'.png');

			unlink($this->pathToFile);
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

