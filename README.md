[![Build Status](https://travis-ci.org/glauberportella/cnab-layouts.svg?branch=master)](https://travis-ci.org/glauberportella/cnab-layouts) [![Code Climate](https://codeclimate.com/github/glauberportella/cnab-layouts/badges/gpa.svg)](https://codeclimate.com/github/glauberportella/cnab-layouts)

# CNAB LAYOUTS

Layouts de arquivos de intercâmbio bancário em formato YAML.

## Bancos e tipos de layout já configurados

| Banco                         | Remessa  | Retorno  |
|:------------------------------|:---------|:---------|
| 001 - Banco do Brasil         | CNAB 240 | CNAB 240 |
| 237 - Bradesco                | CNAB 240 | CNAB 240 |
| 104 - Caixa Econômica Federal | CNAB 240 | CNAB 240 |
| 341 - Itaú                    | CNAB 240 | CNAB 240 |
| 033 - Santander               | CNAB 240 | CNAB 240 |

## O que eu preciso saber

* Utilizamos nomes simples para o campo, por exemplo para "Código do banco" utilize o "codigo_banco" (com underline e sem o "do")
* Para definir o tipo do campo utilizamos uma Picture

## O que é uma Picture

Essa Picture foi baseada na documentação do itaú, disponível em http://download.itau.com.br/bankline/layout_cobranca_400bytes_cnab_itau_mensagem.pdf

Cada registro é formado por campos que são apresentados em dois formatos:

* Alfanumérico (picture X): alinhados à esquerda com brancos à direita. Preferencialmente, todos os caracteres devem ser maiúsculos. Aconselhase a não utilização de caracteres especiais (ex.: “Ç”, “?”,, etc) e acentuação gráfica (ex.: “Á”, “É”, “Ê”, etc) e os campos não utiliza dos deverão ser preenchidos com brancos.

* Numérico (picture 9): alinhado à direita com zeros à esquerda e os campos não utilizados deverão ser preenchidos com zeros. - Vírgula assumida (picture V): indica a posição da vírgula dentro de um campo numérico. E xemplo: num campo com picture “9(5)V9(2)”, o número “876,54” será representado por “0087654”

# Como criar um layout

Arquivos de layout definem o modelo de dados. Os arquivos de layout são arquivos YAML e devem ser salvos com a seguinte nomenclatura `/config/<banco>/cnab[240|400]/nome_servico.yml`. Isso é uma convenção para manter a organização, você pode salvar em qualquer local e com o nome que desejar.

Para criar um layout obtenha o manual junto ao Banco e siga o padrão de formato do YAML:

```yaml
# FORMATO: <INFORME SOBRE O FORMATO DO ARQUIVO CNAB240 ou CNAB400
# OBJETIVO DO ARQUIVO: <INFORME O OBJETIVO DO LAYOUT DO ARQUIVO, PAGAMENTO, COBRANÇA, ETC.
#
# <INFORME DEMAIS DADOS IMPORTANTES SOBRE O LAYOUT
# 

# Serviço/produto fornecido pelo layout
servico: 'pagamentos'

# Versão do layout
versao: '09.1'

# definição do layout de arquivos de remessa
remessa:
	header_arquivo:
		...
	trailer_arquivo:
		...
	header_lote:
		...
	trailer_lote:
		...
	# CONVENÇÃO IMPORTANTE: cada segmento deve ser nomeado no formato "segmento_[letra]", 
	# ou seja, espaços em branco devem ser substituídos por '_' (sublinhado)
	detalhes:
		segmento_a:
			...
		segmento_b:
			...
		...
		segmento_z:
			...
# definição do layout de arquivos de retorno
retorno:
	header_arquivo:
		...
	trailer_arquivo:
		...
	header_lote:
		...
	trailer_lote:
		...
	# CONVENÇÃO IMPORTANTE: cada segmento deve ser nomeado no formato "segmento_[letra]", 
	# ou seja, espaços em branco devem ser substituídos por '_' (sublinhado)
	detalhes:
		segmento_a:
			...
		segmento_b:
			...
		...
		segmento_z:
			...
```

# Usando o Parser

Na pasta `/parser` existe a implementação do parser dos layouts criados, segue abaixo exemplo de utilização.

**Obs.:** Entre na pasta `/parser` e execute `composer install` para instalar as dependências.

Conforme informado acima, em **Como criar um Layout**, o arquivo de layout define o modelo de dados, ou seja, a classe Remessa e Retorno possuem atributos com o nome das chaves existentes no arquivo YAML do layout.

# Exemplos

## Arquivo de Remessa

Gerando um arquivo Remessa de pagamentos via DOC, TED, crédito em conta, etc. formato FEBRABAN CNAB240:

```php
<?php 
require_once __DIR__.'/vendor/autoload.php';

use CnabParser\Parser\Layout;
use CnabParser\Model\Remessa;
use CnabParser\Output\RemessaFile;

$remessaLayout = new Layout(__DIR__.'/config/febraban/cnab240/pagamentos.yml');
$remessa = new Remessa($remessaLayout);

// preenche campos
$remessa->header_arquivo->codigo_banco = 341;
$remessa->header_arquivo->lote_servico = 0;
$remessa->header_arquivo->tipo_registro = 0;
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
$remessa->header_arquivo->versao_layout_arquivo = '091';
$remessa->header_arquivo->densidade_gravacao_arquivo = '1600';
$remessa->header_arquivo->reservado_banco_01 = '';
$remessa->header_arquivo->reservado_empresa_01 = '';
$remessa->header_arquivo->exclusivo_febraban_03 = '';

// header lote
$remessa->header_lote->codigo_banco = 341;
$remessa->header_lote->lote_servico = 1;
$remessa->header_lote->tipo_registro = 1;
$remessa->header_lote->tipo_operacao = 'C';
$remessa->header_lote->tipo_servico = 30;
$remessa->header_lote->forma_lancamento = '02';
$remessa->header_lote->versao_layout_lote = '045';
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
$remessa->trailer_lote->tipo_registro = 5;
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
$remessaFile->generate(__DIR__.'/out/remessa-pagamento.rem');
```

## Retorno

Processando um arquivo de retorno transformando-o em modelo para uso em seu sistema.

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

use CnabParser\Parser\Layout;
use CnabParser\Model\Retorno;
use CnabParser\Input\RetornoFile;

$layout = new Layout(__DIR__.'/config/itau/cnab240/cobranca_bloqueto.yml');
$retornoFile = new RetornoFile($layout, __DIR__.'/data/cobranca-itau-cnab240.ret');

// Gera o objeto instancia de CnabParser\Model\Retorno com os dados do arquivo de retorno processado
$retorno = $retornoFile->generate();

// ... utilize o $retorno em seu sistema para verificações, etc. ...
```

# A Fazer

2. Criar layouts padrões para todos os serviços conforme manual FEBRABAN CNAB240
3. Criar layouts dos principais bancos: Banco do Brasil, Caixa, Itaú, Santander, Bradesco, HSBC, etc.

# Referências

Baseado em projeto CNAB YAML de https://github.com/andersondanilo/cnab_yaml

# Licença

The MIT License (MIT)

Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.