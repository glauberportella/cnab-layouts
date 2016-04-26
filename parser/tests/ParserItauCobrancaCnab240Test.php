<?php

use CnabParser\Parser\Layout;
use CnabParser\Model\Remessa;
use CnabParser\Output\RemessaFile;

class ParserItauCobrancaCnab240Test extends \PHPUnit_Framework_TestCase
{
	public function testDeveInstanciarLayout()
	{
		$layout = new Layout(__DIR__.'/../../config/itau/cnab240/cobranca_bloqueto.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);
	}

	public function testRemessaOk()
	{
		$remessaLayout = new Layout(__DIR__.'/../../config/itau/cnab240/cobranca_bloqueto.yml');
		$remessa = new Remessa($remessaLayout);
		$this->assertInstanceOf('CnabParser\Model\Remessa', $remessa);
		
		// campos da remessa
		
			
		// gera arquivo
		$remessaFile = new RemessaFile($remessa);
		$this->assertInstanceOf('CnabParser\Output\RemessaFile', $remessaFile);
		$remessaFile->generate(__DIR__.'/out/itau-cobanca-cnab240.rem');
	}
}