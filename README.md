# CNAB LAYOUTS

Layouts de arquivos de intercâmbio bancário em formato YAML.

## O que eu preciso saber

* Utilizamos nomes simples para o campo, por exemplo para "Código do banco" utilize o "codigo_banco" (com underline e sem o "do")
* Para definir o tipo do campo utilizamos uma Picture

## O que é uma Picture

Essa Picture foi baseada na documentação do itaú, disponível em http://download.itau.com.br/bankline/layout_cobranca_400bytes_cnab_itau_mensagem.pdf

Cada registro é formado por campos que são apresentados em dois formatos:

* Alfanumérico (picture X): alinhados à esquerda com brancos à direita. Preferencialmente, todos os caracteres devem ser maiúsculos. Aconselhase a não utilização de caracteres especiais (ex.: “Ç”, “?”,, etc) e acentuação gráfica (ex.: “Á”, “É”, “Ê”, etc) e os campos não utiliza dos deverão ser preenchidos com brancos.

* Numérico (picture 9): alinhado à direita com zeros à esquerda e os campos não utilizados deverão ser preenchidos com zeros. - Vírgula assumida (picture V): indica a posição da vírgula dentro de um campo numérico. E xemplo: num campo com picture “9(5)V9(2)”, o número “876,54” será representado por “0087654”

# Referências

** Baseado em projeto CNAB YAML de https://github.com/andersondanilo/cnab_yaml **