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
		$remessa->header_arquivo->codigo_banco = 341;
		$remessa->header_arquivo->tipo_inscricao = 2;
		$remessa->header_arquivo->inscricao_numero = '05346078000186';
		$remessa->header_arquivo->agencia = 2932;
		$remessa->header_arquivo->conta = 24992;
		$remessa->header_arquivo->dac = 9;
		$remessa->header_arquivo->nome_empresa = 'MACWEB SOLUTIONS LTDA';
		$remessa->header_arquivo->data_geracao = date('dmY');
		$remessa->header_arquivo->hora_geracao = date('His');
		$remessa->header_arquivo->numero_sequencial_arquivo_retorno = 1;
		
		$remessa->header_lote->lote_servico = 1;
		$remessa->header_lote->tipo_inscricao = 2;
		$remessa->header_lote->inscricao_empresa = '05346078000186';
		$remessa->header_lote->agencia = 2932;
		$remessa->header_lote->conta = 24992;
		$remessa->header_lote->dac = 9;
		$remessa->header_lote->nome_empresa = 'MACWEB SOLUTIONS LTDA';
		$remessa->header_lote->numero_sequencial_arquivo_retorno = 1;
		$remessa->header_lote->data_gravacao = date('dmY');
		$remessa->header_lote->data_credito = date('dmY');

		$remessa->trailer_lote->lote_servico = 1;
		$remessa->trailer_lote->quantidade_registros_lote = 1;
		$remessa->trailer_lote->quantidade_cobranca_simples = 1;
		$remessa->trailer_lote->valor_total_cobranca_simples = 10000;
		$remessa->trailer_lote->quantidade_cobranca_vinculada = 0;
		$remessa->trailer_lote->valor_total_cobranca_vinculada = 0;

		$remessa->trailer_arquivo->total_lotes = 1;
		$remessa->trailer_arquivo->total_registros = 1;

		$detalhe = $remessa->novoDetalhe();
		// segmento p
		$detalhe->segmento_p->lote_servico = 1;
		$detalhe->segmento_p->nummero_sequencial_registro_lote = 1;
		$detalhe->segmento_p->codigo_ocorrencia = '01';
		$detalhe->segmento_p->agencia = 2932;
		$detalhe->segmento_p->conta = 24992;
		$detalhe->segmento_p->dac = 9;
		$detalhe->segmento_p->carteira = 109;
		$detalhe->segmento_p->nosso_numero = 12345678;
		$detalhe->segmento_p->dac_nosso_numero = 3;
		$detalhe->segmento_p->numero_documento = 1;
		$detalhe->segmento_p->vencimento = '10052016';
		$detalhe->segmento_p->valor_titulo = 1000;
		$detalhe->segmento_p->agencia_cobradora = 2932;
		$detalhe->segmento_p->dac_agencia_cobradora = 0;
		$detalhe->segmento_p->especie = '05';
		$detalhe->segmento_p->aceite = 'N';
		$detalhe->segmento_p->data_emissao = date('dmY');
		$detalhe->segmento_p->data_juros_mora = '11052016';
		$detalhe->segmento_p->juros_1_dia = 0;
		$detalhe->segmento_p->data_1o_desconto = '00000000';
		$detalhe->segmento_p->valor_1o_desconto = 0;
		$detalhe->segmento_p->valor_iof = 38;
		$detalhe->segmento_p->valor_abatimento = 0;
		$detalhe->segmento_p->identificacao_titulo_empresa = '';
		$detalhe->segmento_p->codigo_negativacao_protesto = 0;
		$detalhe->segmento_p->prazo_negativacao_protesto = 0;
		$detalhe->segmento_p->codigo_baixa = 0;
		$detalhe->segmento_p->prazo_baixa = 0;
		// segmento q
		$detalhe->segmento_q->lote_servico = 1;
		$detalhe->segmento_q->nummero_sequencial_registro_lote = 1;
		$detalhe->segmento_q->codigo_ocorrencia = '01';
		$detalhe->segmento_q->tipo_inscricao = 2;
		$detalhe->segmento_q->inscricao_numero = '05346078000186';
		$detalhe->segmento_q->nome_pagador = 'GLAUBER PORTELLA';
		$detalhe->segmento_q->logradouro = 'RUA ALVARENGA';
		$detalhe->segmento_q->bairro = 'GUARANI';
		$detalhe->segmento_q->cep = 31814;
		$detalhe->segmento_q->sufixo_cep = 500;
		$detalhe->segmento_q->cidade = 'BELO HORIZONTE';
		$detalhe->segmento_q->uf = 'MG';
		$detalhe->segmento_q->tipo_inscricao_sacador = 2;
		$detalhe->segmento_q->inscricao_sacador = '05346078000186';
		$detalhe->segmento_q->nome_sacador = 'MACWEB SOLUTIONS LTDA';
		// segmento r opcional nao adicionado no layout
		// segmento y opcional nao adicionado no layout
		
		// insere o detalhe na remessa
		$remessa->inserirDetalhe($detalhe);

		// gera arquivo
		$remessaFile = new RemessaFile($remessa);
		$this->assertInstanceOf('CnabParser\Output\RemessaFile', $remessaFile);
		$remessaFile->generate(__DIR__.'/out/itau-cobanca-cnab240.rem');
	}
}