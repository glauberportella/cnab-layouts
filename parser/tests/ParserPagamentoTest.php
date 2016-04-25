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
		$remessa->trailer_arquivo->codigo_banco = 341;
    	$remessa->trailer_arquivo->lote_servico = 9999;
    	$remessa->trailer_arquivo->tipo_registro = 9;
    	$remessa->trailer_arquivo->exclusivo_febraban_01 = '';
    	$remessa->trailer_arquivo->quantidade_lotes_arquivo = 1;
    	$remessa->trailer_arquivo->quantidade_registros_arquivo = 1;
    	$remessa->trailer_arquivo->quantidade_contas_conciliacao_lotes = 1;
    	$remessa->trailer_arquivo->exclusivo_febraban_02 = '';

		// segmentos
		// segmento a
		$remessa->detalhes->segmento_a->codigo_banco = '';
		$remessa->detalhes->segmento_a->lote_servico = '';
		$remessa->detalhes->segmento_a->tipo_registro = '';
		$remessa->detalhes->segmento_a->numero_sequencial_registro_lote = '';
		$remessa->detalhes->segmento_a->codigo_segmento_registro_detalhe = '';
		$remessa->detalhes->segmento_a->tipo_movimento = '';
		$remessa->detalhes->segmento_a->codigo_instrucao_movimento = '';
		$remessa->detalhes->segmento_a->codigo_camara_centralizadora = '';
		$remessa->detalhes->segmento_a->codigo_banco_favorecido = '';
		$remessa->detalhes->segmento_a->agencia_mantenedora_conta_favorecido = '';
		$remessa->detalhes->segmento_a->digito_verificador_agencia = '';
		$remessa->detalhes->segmento_a->numero_conta_corrente = '';
		$remessa->detalhes->segmento_a->digito_verificador_conta = '';
		$remessa->detalhes->segmento_a->digito_verificador_agencia_conta = '';
		$remessa->detalhes->segmento_a->nome_favorecido = '';
		$remessa->detalhes->segmento_a->numero_documento_atribuido_empresa = '';
		$remessa->detalhes->segmento_a->data_pagamento = '';
		$remessa->detalhes->segmento_a->tipo_moeda = '';
		$remessa->detalhes->segmento_a->quantidade_moeda = '';
		$remessa->detalhes->segmento_a->valor_pagamento = '';
		$remessa->detalhes->segmento_a->numero_documento_atribuido_banco = '';
		$remessa->detalhes->segmento_a->data_real_efetivacao_pagamento = '';
		$remessa->detalhes->segmento_a->valor_real_efetivacao_pagamento = '';
		$remessa->detalhes->segmento_a->outras_informacoes = '';
		$remessa->detalhes->segmento_a->complemento_tipo_servico = '';
		$remessa->detalhes->segmento_a->codigo_finalidade_ted = '';
		$remessa->detalhes->segmento_a->complemento_finalidade_pagamento = '';
		$remessa->detalhes->segmento_a->exclusivo_febraban_01 = '';
		$remessa->detalhes->segmento_a->aviso_favorecido = '';
		$remessa->detalhes->segmento_a->codigos_ocorrencias_retorno = '';
		// segmento b
		$remessa->detalhes->segmento_b->codigo_banco = '';
		$remessa->detalhes->segmento_b->lote_servico = '';
		$remessa->detalhes->segmento_b->tipo_registro = '';
		$remessa->detalhes->segmento_b->numero_sequencial_registro_lote = '';
		$remessa->detalhes->segmento_b->codigo_segmento_registro_detalhe = '';
		$remessa->detalhes->segmento_b->exclusivo_febraban_01 = '';
		$remessa->detalhes->segmento_b->tipo_inscricao_favorecido = '';
		$remessa->detalhes->segmento_b->numero_inscricao_favorecido = '';
		$remessa->detalhes->segmento_b->logradouro = '';
		$remessa->detalhes->segmento_b->numero = '';
		$remessa->detalhes->segmento_b->complemento = '';
		$remessa->detalhes->segmento_b->bairro = '';
		$remessa->detalhes->segmento_b->cidade = '';
		$remessa->detalhes->segmento_b->cep = '';
		$remessa->detalhes->segmento_b->complemento_cep = '';
		$remessa->detalhes->segmento_b->estado = '';
		$remessa->detalhes->segmento_b->data_vencimento_nominal = '';
		$remessa->detalhes->segmento_b->valor_documento_nominal = '';
		$remessa->detalhes->segmento_b->valor_abatimento = '';
		$remessa->detalhes->segmento_b->valor_desconto = '';
		$remessa->detalhes->segmento_b->valor_mora = '';
		$remessa->detalhes->segmento_b->valor_multa = '';
		$remessa->detalhes->segmento_b->codigo_documento_favorecido = '';
		$remessa->detalhes->segmento_b->aviso_favorecido = '';
		$remessa->detalhes->segmento_b->exclusivo_siape_01 = '';
		$remessa->detalhes->segmento_b->codigo_ispb = '';
		// segmento c
		$remessa->detalhes->segmento_c->codigo_banco = '';
		$remessa->detalhes->segmento_c->lote_servico = '';
		$remessa->detalhes->segmento_c->tipo_registro = '';
		$remessa->detalhes->segmento_c->numero_sequencial_registro_lote = '';
		$remessa->detalhes->segmento_c->codigo_segmento_registro_detalhe = '';
		$remessa->detalhes->segmento_c->exclusivo_febraban_01 = '';
		$remessa->detalhes->segmento_c->valor_ir = '';
		$remessa->detalhes->segmento_c->valor_iss = '';
		$remessa->detalhes->segmento_c->valor_iof = '';
		$remessa->detalhes->segmento_c->valor_outras_deducoes = '';
		$remessa->detalhes->segmento_c->valor_outros_acrescimos = '';
		$remessa->detalhes->segmento_c->agencia_favorecido = '';
		$remessa->detalhes->segmento_c->digito_verificador_agencia = '';
		$remessa->detalhes->segmento_c->numero_conta_corrente = '';
		$remessa->detalhes->segmento_c->digito_verificador_conta = '';
		$remessa->detalhes->segmento_c->digito_verificador_agencia_conta = '';
		$remessa->detalhes->segmento_c->valor_inss = '';
		$remessa->detalhes->segmento_c->exclusivo_febraban_02 = '';

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