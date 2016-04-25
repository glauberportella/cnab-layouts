<?php

class ParserTest extends \PHPUnit_Framework_TestCase
{
	public function testRemessaPagamentosOk()
	{
		$remessaLayout = new Layout(__DIR__.'/../config/febraban/cnab240/pagamentos.yml');
		$remessa = new Remessa($remessaLayout);
		// preenche campos
		// gera arquivo
		$remessaFile = new RemessaFile($remessa);
		$remessaFile->generate(__DIR__.'/out/remessa-pagamento.rem');
	}

	public function testRetornoPagamentosOK()
	{
		$retornoLayout = new Layout(__DIR__.'/../config/febraban/cnab240/pagamentos.yml');
		$retornoReader = new RetornoReader($retornoLayout);
		$retorno = $retornoReader->read(__DIR__'/in/retorno.ret');
	}
}