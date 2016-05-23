<?php

use CnabParser\Parser\Layout;

class Bb400CobrancaTest extends \PHPUnit_Framework_TestCase
{
	public function testDeveInstanciarLayout()
	{
		$layout = new Layout(__DIR__.'/../../../../../../config/bb/cnab400/cobranca_convenio_7_digitos.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);
	}
}