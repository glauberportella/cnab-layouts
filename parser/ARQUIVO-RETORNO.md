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
1) Inicia na linha 1 do arquivo
2) Leia a linha
3) Leia tipo de registro (campo tipo de registro, posição 8 picture 9(1))
4) Se tipo de registro == 0 ou == 9 pula para proxima linha e volta ao passo 2
5) Se tipo de registro == 1 então é novo lote, guarda o código do lote pula para próxima linha e volta ao passo 2
6) Se tipo de registro == 3 então
6.1) Leia codigo do lote
6.2) Se não é o mesmo que o código guardado no passo 5 pula para próxima linha e volta ao passo 2
6.3) Leia codigo do segmento 
// CONTINUAR DAQUI
7) Senão se tipo de registro == 5 finaliza lote pula para próxima linha e volta ao passo 2
8) Senão tipo de registro não conhecido pula para próxima linha se houver e volta ao passo 2, se não há mais linha finaliza.
```