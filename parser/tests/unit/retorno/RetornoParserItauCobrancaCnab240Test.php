<?php

use CnabParser\Parser\Layout;
use CnabParser\Model\Retorno;
use CnabParser\Input\RetornoFile;

class RetornoParserItauCobrancaCnab240Test extends \PHPUnit_Framework_TestCase
{
	public function testRetornoFileInstanceSuccess()
	{
		$layout = new Layout(__DIR__.'/../../../../config/itau/cnab240/cobranca_bloqueto.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);

		$retornoFile = new RetornoFile($layout, __DIR__.'/../../data/cobranca-itau-cnab240.ret');
		$this->assertInstanceOf('CnabParser\Input\RetornoFile', $retornoFile);
	}

	public function testRetornoGenerateModelSuccess()
	{
		$layout = new Layout(__DIR__.'/../../../../config/itau/cnab240/cobranca_bloqueto.yml');
		$retornoFile = new RetornoFile($layout, __DIR__.'/../../data/cobranca-itau-cnab240.ret');

		$this->assertEquals(1, $retornoFile->getTotalLotes());

		$retorno = $retornoFile->generate();
		$this->assertInstanceOf('CnabParser\Model\Retorno', $retorno);
		$this->assertInstanceOf('StdClass', $retorno->header_arquivo);
		$this->assertNotEmpty($retorno->lotes);
		
		// verifica header_arquivo
		$this->assertEquals(341, $retorno->header_arquivo->codigo_banco);
		$this->assertEquals(0, $retorno->header_arquivo->lote_servico);
		$this->assertEquals(0, $retorno->header_arquivo->tipo_registro);
		$this->assertEquals('', $retorno->header_arquivo->brancos_01);
		$this->assertEquals(2, $retorno->header_arquivo->tipo_inscricao);
		$this->assertEquals('15594050000111', $retorno->header_arquivo->inscricao_numero);
		$this->assertEquals('', $retorno->header_arquivo->brancos_02);
		$this->assertEquals(0, $retorno->header_arquivo->zeros_01);
		$this->assertEquals(4459, $retorno->header_arquivo->agencia);
		$this->assertEquals('', $retorno->header_arquivo->brancos_03);
		$this->assertEquals(0, $retorno->header_arquivo->zeros_02);
		$this->assertEquals(17600, $retorno->header_arquivo->conta);
		$this->assertEquals('', $retorno->header_arquivo->brancos_04);
		$this->assertEquals(6, $retorno->header_arquivo->dac);
		$this->assertEquals('TRACY INFORMATICA LTDA - ME', $retorno->header_arquivo->nome_empresa);
		$this->assertEquals('BANCO ITAU S.A.', $retorno->header_arquivo->nome_banco);
		$this->assertEquals('', $retorno->header_arquivo->brancos_05);
		$this->assertEquals(2, $retorno->header_arquivo->codigo_arquivo);
		$this->assertEquals('05072012', $retorno->header_arquivo->data_geracao);
		$this->assertEquals('163917', $retorno->header_arquivo->hora_geracao);
		$this->assertEquals(4, $retorno->header_arquivo->numero_sequencial_arquivo_retorno);
		$this->assertEquals('040', $retorno->header_arquivo->versao_layout_arquivo);
		$this->assertEquals(0, $retorno->header_arquivo->zeros_03);
		$this->assertEquals('', $retorno->header_arquivo->brancos_06);
		$this->assertEquals(0, $retorno->header_arquivo->zeros_04);
		$this->assertEquals('', $retorno->header_arquivo->brancos_07);

		// verifica trailer_arquivo
		$this->assertEquals(341, $retorno->trailer_arquivo->codigo_banco);
		$this->assertEquals(9999, $retorno->trailer_arquivo->lote_servico);
		$this->assertEquals(9, $retorno->trailer_arquivo->registro);
		$this->assertEquals('', $retorno->trailer_arquivo->brancos_01);
		$this->assertEquals(1, $retorno->trailer_arquivo->total_lotes);
		$this->assertEquals(8, $retorno->trailer_arquivo->total_registros);
		$this->assertEquals(0, $retorno->trailer_arquivo->zeros_01);
		$this->assertEquals('', $retorno->trailer_arquivo->brancos_02);
	}
}