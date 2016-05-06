<?php

require_once __DIR__.'/vendor/autoload.php';

use CnabParser\Parser\Layout;
use CnabParser\Input\RetornoFile;

$layout = new Layout(__DIR__.'/../config/itau/cnab240/cobranca_bloqueto.yml');
$retornoFile = new RetornoFile($layout, __DIR__.'/tests/data/cobranca-itau-cnab240.ret');

$retorno = $retornoFile->generate();