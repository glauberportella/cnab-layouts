<?php

namespace CnabParser\Input;

use CnabParser\IntercambioBancarioRetornoFileAbstract;
use CnabParser\Exception\RetornoException;
use CnabParser\Format\Picture;

class RetornoFile extends IntercambioBancarioRetornoFileAbstract
{
	/**
	 * Para retorno o metodo em questao gera o modelo Retorno conforme layout
	 * @param  string $path Não necessario
	 * @return CnabParser\Model\Retorno
	 */
	public function generate($path = null)
	{
		$this->generateHeaderArquivo();
		$this->generateTrailerArquivo();
		return $this->model;
	}

	/**
	 * Processa header_arquivo
	 */
	protected function generateHeaderArquivo()
	{
		$retornoLayout = $this->layout->getRetornoLayout();
		$definicoes = $retornoLayout['header_arquivo'];
		
		// linha referente ao registro de header de arquivo (indice 0)
		$linhaTxt = $this->linhas[0];

		foreach ($definicoes as $campo => $definicao) {
			$valor = $this->obterValorCampoDaLinha($linhaTxt, $definicao);
			$this->model->header_arquivo->{$campo} = $valor;
		}
	}

	/**
	 * Processa trailer_arquivo
	 */
	protected function generateTrailerArquivo()
	{

	}

	protected function obterValorCampoDaLinha($linha, array $definicao)
	{
		if (1 !== preg_match(Picture::REGEX_VALID_FORMAT, $definicao['picture'], $tipo)) {
			throw new RetornoException('Erro ao obter valor de linha de registro do arquivo de retorno.');
		}

		$inicio = $definicao['pos'][0] - 1;
		$tamanho1 = !empty($tipo['tamanho1']) ? (int)$tipo['tamanho1'] : 0;
		$tamanho2 = !empty($tipo['tamanho2']) ? (int)$tipo['tamanho2'] : 0;
		$tamanho = $tamanho1 + $tamanho2;
		$formato = $definicao['picture'];
		$opcoes = array();

		return Picture::decode(substr($linha, $inicio, $tamanho), $formato, $opcoes);
	}
}