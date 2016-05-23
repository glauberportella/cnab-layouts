<?php

use CnabParser\Parser\Layout;

class Bradesco400CobrancaTest extends \PHPUnit_Framework_TestCase
{
	public function testDeveInstanciarLayout()
	{
		$layout = new Layout(__DIR__.'/../../../../../../config/bradesco/cnab400/cobranca.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);
	}
}