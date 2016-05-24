# CNAB LAYOUTS

Layouts de arquivos de intercâmbio bancário em formato YAML.

## Bancos e tipos de layout já configurados

### Cobrança (boleto)

| Banco                         | Remessa             | Retorno             |
|:------------------------------|:--------------------|:--------------------|
| 001 - Banco do Brasil         | CNAB 240 - CNAB 400 | CNAB 240 - CNAB 400 |
| 237 - Bradesco                | CNAB 240 - CNAB 400 | CNAB 240 - CNAB 400 |
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

# Ok, como posso utilizar os layouts?

Existe o projeto [CNAB Layouts Parser](http://glauberportella.github.io/cnab-layouts-parser) que implementa um **parser** para os layouts criados aqui.

Conforme informado acima, em **Como criar um Layout**, o arquivo de layout define o modelo de dados, ou seja, a classe Remessa e Retorno possuem atributos com o nome das chaves existentes no arquivo YAML do layout.

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
