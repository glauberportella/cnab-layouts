#Estrutura do arquivo retorno CNAB 240:

Cada arquivo pode ter mais de um tipo de lote/servico. Entre parênteses estão os números dos registros.

```
(0) header-arquivo

(1) header-lote
(3) detalhes (segmentos)
(5) trailer-lote

(1) header-lote
(3) detalhes (segmentos)
(5) trailer-lote

...

(1) header-lote
(3) detalhes (segmentos)
(5) trailer-lote

(9) trailer-arquivo
```

#Lendo um lote:

Conforme CNAB 240 cada header lote (1), detalhes (3) e trailer lote (5) possui o campo sequencial que identifica o lote (campo código do lote, posição 4 a 7 picture 9(4))

##Idéia do algoritmo:

Assumindo que o arquivo vem em ordem de lotes

```
Início

    var
        tipo_registro: inteiro          // tipo de registro da linha
        codigo_lote: inteiro            // código sequêncial do lote
        codigo_lote_segmento: inteiro   // referência ao código sequencial do lote do registro detalhe
        codigo_segmento: caractere      // código do segmento do registro detalhe
        numero_registro: inteiro        // número sequencial do registro detalhe dentro do lote
        indice_detalhe: inteiro         //
        linha: string                   // a linha sendo processada
        lote: matriz

    "Inicia na primeira linha do arquivo"

    // inicia lote como uma matriz vazia
    lote := []
    
    indice_detalhe := 0
    
    Enquanto linha := "Leia a linha" faça
        tipo_registro := "Leia tipo de registro (campo tipo de registro, posição 8 picture 9(1))"
        Se tipo_registro = 1 então // é novo lote
            codigo_lote := "leia o código do lote"
            lote[codigo_lote] := "nova matriz"
        senão se tipo_registro = 3 então // detalhe
            codigo_lote_segmento := "Leia código do lote"
            Se codigo_lote_segmento != codigo_lote então
                continua
            Fim se
            codigo_segmento := "Leia código do segmento"
            numero_registro := "Leia número do registro (campo posição 9 a 13, picture 9(5))"
            lote[codigo_lote][indice_detalhe][codigo_segmento] := "Leia dados da linha"
            Se codigo_segmento = "Último código de segmento do layout" então
                indice_detalhe := indice_detalhe + 1
            Fim se
        Fim se
    Fim enquanto
    
Fim.