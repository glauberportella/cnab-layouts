<?php
require_once __DIR__.'/vendor/autoload.php';

use CnabParser\Parser\Layout;
use CnabParser\Model\Remessa;
use CnabParser\Output\RemessaFile;

/*
 * Layout PAGAMENTOS FEBRABAN
 */
$remessaLayout = new Layout(__DIR__.'/../config/itau/cnab240/cobranca_bloqueto.yml');
$remessa = new Remessa($remessaLayout);
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

$remessa->header_lote->codigo_banco = 341;
$remessa->header_lote->lote_servico = 1;
$remessa->header_lote->tipo_registro = 1;
$remessa->header_lote->tipo_operacao = 'R';
$remessa->header_lote->tipo_servico = '01';
$remessa->header_lote->zeros_01 = 0;
$remessa->header_lote->versao_layout_lote = '030';
$remessa->header_lote->brancos_01 = '';
$remessa->header_lote->tipo_inscricao = 2;
$remessa->header_lote->inscricao_empresa = '05346078000186';
$remessa->header_lote->brancos_02 = 0;
$remessa->header_lote->zeros_02 = 0;
$remessa->header_lote->agencia = 2932;
$remessa->header_lote->brancos_03 = '';
$remessa->header_lote->zeros_03 = 0;
$remessa->header_lote->conta = '24992';
$remessa->header_lote->brancos_04 = '';
$remessa->header_lote->dac = 9;
$remessa->header_lote->nome_empresa = 'MACWEB SOLUTIONS LTDA';
$remessa->header_lote->brancos_05 = '';
$remessa->header_lote->numero_sequencial_arquivo_retorno = 1;
$remessa->header_lote->data_gravacao = date('dmY');
$remessa->header_lote->data_credito = date('dmY');
$remessa->header_lote->brancos_06 = '';

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
$remessaFile->generate(__DIR__.'/tests/out/itaucobranca240.rem');

/*
 * Layout PAGAMENTOS FEBRABAN
 */
/*
$remessaLayout = new Layout(__DIR__.'/../config/febraban/cnab240/pagamentos.yml');
$remessa = new Remessa($remessaLayout);

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

// detalhes
$detalhe = $remessa->novoDetalhe();
// segmento a
$detalhe->segmento_a->codigo_banco = 341;
$detalhe->segmento_a->lote_servico = 1;
$detalhe->segmento_a->tipo_registro = 3;
$detalhe->segmento_a->numero_sequencial_registro_lote = 1;
$detalhe->segmento_a->codigo_segmento_registro_detalhe = 'A';
$detalhe->segmento_a->tipo_movimento = 0;
$detalhe->segmento_a->codigo_instrucao_movimento = '00';
$detalhe->segmento_a->codigo_camara_centralizadora = '700';
$detalhe->segmento_a->codigo_banco_favorecido = 341;
$detalhe->segmento_a->agencia_mantenedora_conta_favorecido = 3158;
$detalhe->segmento_a->digito_verificador_agencia = '';
$detalhe->segmento_a->numero_conta_corrente = 38094;
$detalhe->segmento_a->digito_verificador_conta = 3;
$detalhe->segmento_a->digito_verificador_agencia_conta = '';
$detalhe->segmento_a->nome_favorecido = 'Glauber Portella';
$detalhe->segmento_a->numero_documento_atribuido_empresa = '12345';
$detalhe->segmento_a->data_pagamento = date('dmY');
$detalhe->segmento_a->tipo_moeda = 'BRL';
$detalhe->segmento_a->quantidade_moeda = 1;
$detalhe->segmento_a->valor_pagamento = '15000';
$detalhe->segmento_a->numero_documento_atribuido_banco = '123456';
$detalhe->segmento_a->data_real_efetivacao_pagamento = date('dmY');
$detalhe->segmento_a->valor_real_efetivacao_pagamento = '15000';
$detalhe->segmento_a->outras_informacoes = '';
$detalhe->segmento_a->complemento_tipo_servico = '06';
$detalhe->segmento_a->codigo_finalidade_ted = '123456';
$detalhe->segmento_a->complemento_finalidade_pagamento = '0';
$detalhe->segmento_a->exclusivo_febraban_01 = '0';
$detalhe->segmento_a->aviso_favorecido = '0';
$detalhe->segmento_a->codigos_ocorrencias_retorno = '00';

// segmento b
$detalhe->segmento_b->codigo_banco = 341;
$detalhe->segmento_b->lote_servico = 1;
$detalhe->segmento_b->tipo_registro = 3;
$detalhe->segmento_b->numero_sequencial_registro_lote = 1;
$detalhe->segmento_b->codigo_segmento_registro_detalhe = 'B';
$detalhe->segmento_b->exclusivo_febraban_01 = '';
$detalhe->segmento_b->tipo_inscricao_favorecido = 1;
$detalhe->segmento_b->numero_inscricao_favorecido = '05771095613';
$detalhe->segmento_b->logradouro = 'Rua Alvarenga';
$detalhe->segmento_b->numero = 40;
$detalhe->segmento_b->complemento = '';
$detalhe->segmento_b->bairro = 'Guarani';
$detalhe->segmento_b->cidade = 'Belo Horizonte';
$detalhe->segmento_b->cep = '31814';
$detalhe->segmento_b->complemento_cep = '500';
$detalhe->segmento_b->estado = 'MG';
$detalhe->segmento_b->data_vencimento_nominal = date('dmY');
$detalhe->segmento_b->valor_documento_nominal = '1500';
$detalhe->segmento_b->valor_abatimento = '0';
$detalhe->segmento_b->valor_desconto = '0';
$detalhe->segmento_b->valor_mora = '0';
$detalhe->segmento_b->valor_multa = '0';
$detalhe->segmento_b->codigo_documento_favorecido = '05771095613';
$detalhe->segmento_b->aviso_favorecido = '';
$detalhe->segmento_b->exclusivo_siape_01 = '';
$detalhe->segmento_b->codigo_ispb = '';

// segmento c
$detalhe->segmento_c->codigo_banco = 341;
$detalhe->segmento_c->lote_servico = 1;
$detalhe->segmento_c->tipo_registro = 3;
$detalhe->segmento_c->numero_sequencial_registro_lote = 1;
$detalhe->segmento_c->codigo_segmento_registro_detalhe = 'C';
$detalhe->segmento_c->exclusivo_febraban_01 = '';
$detalhe->segmento_c->valor_ir = '0';
$detalhe->segmento_c->valor_iss = '0';
$detalhe->segmento_c->valor_iof = '0';
$detalhe->segmento_c->valor_outras_deducoes = '0';
$detalhe->segmento_c->valor_outros_acrescimos = '0';
$detalhe->segmento_c->agencia_favorecido = 3158;
$detalhe->segmento_c->digito_verificador_agencia = '';
$detalhe->segmento_c->numero_conta_corrente = 38094;
$detalhe->segmento_c->digito_verificador_conta = 3;
$detalhe->segmento_c->digito_verificador_agencia_conta = '';
$detalhe->segmento_c->valor_inss = '0';
$detalhe->segmento_c->exclusivo_febraban_02 = '';
$remessa->inserirDetalhe($detalhe);
	
// gera arquivo
$remessaFile = new RemessaFile($remessa);
$remessaFile->generate(__DIR__.'/tests/out/remessa-pagamento.rem');
*/