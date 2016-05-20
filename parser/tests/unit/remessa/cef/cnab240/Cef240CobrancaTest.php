<?php

use CnabParser\Parser\Layout;

class Cef240CobrancaTest extends \PHPUnit_Framework_TestCase
{
	public function testDeveInstanciarLayout()
	{
		$layout = new Layout(__DIR__.'/../../../../../../config/cef/cnab240/cobranca_sigcb.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);
	}
}