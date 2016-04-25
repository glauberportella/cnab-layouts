<?php

use CnabParser\Parser\Layout;
use CnabParser\Model\Remessa;
use CnabParser\Output\RemessaFile;

class ParserPagamentoTest extends \PHPUnit_Framework_TestCase
{
	public function testDeveInstanciarLayout()
	{
		$layout = new Layout(__DIR__.'/../../config/febraban/cnab240/pagamentos.yml');
		$this->assertInstanceOf('CnabParser\Parser\Layout', $layout);
	}

	public function testRemessaPagamentosOk()
	{
		$remessaLayout = new Layout(__DIR__.'/../../config/febraban/cnab240/pagamentos.yml');
		$remessa = new Remessa($remessaLayout);
		$this->assertInstanceOf('CnabParser\Model\Remessa', $remessa);
		
		// preenche campos
		$remessa->header_arquivo->codigo_banco = 341;
		//$remessa->header_arquivo->lote_servico = 0;
		//$remessa->header_arquivo->tipo_registro = 0;
		$remessa->header_arquivo->exclusivo_febraban_01 = '';
		$remessa->header_arquivo->tipo_inscricao_empresa = 2;
		$remessa->header_arquivo->numero_inscricao_empresa = '05346078000186';
		$remessa->header_arquivo->codigo_convenio_banco = '0';
		$remessa->header_arquivo->agencia_mantenedora_conta = '2932';
		$remessa->header_arquivo->digito_verificador_agencia = '';
		$remessa->header_arquivo->numero_conta_corrente = '24992';
		$remessa->header_arquivo->digito_verificador_conta = '9';
		$remessa->header_arquivo->digito_verificador_agencia_conta = '';
		$remessa->header_arquivo->nome_empresa = 'MacWeb Solutions Ltda';
		$remessa->header_arquivo->nome_banco = 'Banco Itaú';
		$remessa->header_arquivo->exclusivo_febraban_02 = '';
		$remessa->header_arquivo->codigo_remessa_retorno = '1';
		$remessa->header_arquivo->data_geracao_arquivo = date('dmY');
		$remessa->header_arquivo->hora_geracao_arquivo = date('His');
		$remessa->header_arquivo->numero_sequencial_arquivo = '1';
		//$remessa->header_arquivo->versao_layout_arquivo = '091';
		$remessa->header_arquivo->densidade_gravacao_arquivo = '1600';
		$remessa->header_arquivo->reservado_banco_01 = '';
		$remessa->header_arquivo->reservado_empresa_01 = '';
		$remessa->header_arquivo->exclusivo_febraban_03 = '';

		// header lote
		$remessa->header_lote->codigo_banco = 341;
		$remessa->header_lote->lote_servico = 1;
		//$remessa->header_lote->tipo_registro = 1;
		//$remessa->header_lote->tipo_operacao = 'C';
		$remessa->header_lote->tipo_servico = 30;
		$remessa->header_lote->forma_lancamento = '02';
		//$remessa->header_lote->versao_layout_lote = '045';
		$remessa->header_lote->exclusivo_febraban_01 = '';
		$remessa->header_lote->tipo_inscricao_empresa = 2;
		$remessa->header_lote->numero_inscricao_empresa = '05346078000186';
		$remessa->header_lote->codigo_convenio_banco = '';
		$remessa->header_lote->agencia_mantenedora_conta = '2932';
		$remessa->header_lote->digito_verificador_agencia = '';
		$remessa->header_lote->numero_conta_corrente = '24992';
		$remessa->header_lote->digito_verificador_conta = '9';
		$remessa->header_lote->digito_verificador_agencia_conta = '';
		$remessa->header_lote->nome_empresa = 'MacWeb Solutions Ltda';
		$remessa->header_lote->mensagem = '';
		$remessa->header_lote->logradouro = 'Rua Guajajaras';
		$remessa->header_lote->numero = '910';
		$remessa->header_lote->complemento = 'sala 1203';
		$remessa->header_lote->cidade = 'Belo Horizonte';
		$remessa->header_lote->cep = '30180';
		$remessa->header_lote->complemento_cep = '100';
		$remessa->header_lote->estado = 'MG';
		$remessa->header_lote->indicativo_forma_pagamento_servico = '01';
		$remessa->header_lote->exclusivo_febraban_02 = '';
		$remessa->header_lote->codigos_ocorrencias_retorno = '';

		// trailer lote
		$remessa->trailer_lote->codigo_banco = 341;
		$remessa->trailer_lote->lote_servico = 1;
		// $remessa->trailer_lote->tipo_registro = 5;
		$remessa->trailer_lote->exclusivo_febraban_01 = '';
		$remessa->trailer_lote->quantidade_registros_lote = 1;
		$remessa->trailer_lote->somatoria_valores = '10000';
		$remessa->trailer_lote->somatoria_quantidade_moedas = '1';
		$remessa->trailer_lote->numero_aviso_debito = '0';
		$remessa->trailer_lote->exclusivo_febraban_02 = '';
		$remessa->trailer_lote->codigos_ocorrencias_retorno = '';
		
		// trailer arquivo
		//$remessa->trailer_arquivo;
	
		// segmentos
		
		// gera arquivo
		$remessaFile = new RemessaFile($remessa);
		$this->assertInstanceOf('CnabParser\Output\RemessaFile', $remessaFile);
		$remessaFile->generate(__DIR__.'/out/remessa-pagamento.rem');
	}

	/*
	public function testRetornoPagamentosOK()
	{
		$retornoLayout = new Layout(__DIR__.'/../config/febraban/cnab240/pagamentos.yml');
		$retornoReader = new RetornoReader($retornoLayout);
		$retorno = $retornoReader->read(__DIR__'/in/retorno.ret');
	}
	*/
}