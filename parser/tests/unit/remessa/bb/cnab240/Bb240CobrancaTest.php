<?php

use CnabParser\Parser\Layout;

class Bb240CobrancaTest extends \PHPUnit_Framework_TestCase
{
	public function testDeveInstanciarLayout()
	{
		$layout = new Layout(__DIR__.'/../../../../../../config/bb/cnab240/cobranca.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);
	}
}