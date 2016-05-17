<?php

namespace CnabParser\Model;

use CnabParser\Parser\Layout;
use CnabParser\Format\Picture;
use CnabParser\Exception\LinhaException;

class Linha
{
	/**
	 * @var CnabParser\Parser\Layout
	 */
	protected $layout;
	/**
	 * @var string
	 */
	protected $linhaStr;
	/**
	 * @var string
	 */
	protected $tipo;


	public function __construct($linhaStr, Layout $layout, $tipo = 'remessa')
	{
		$this->linhaStr = $linhaStr;
		$this->layout = $layout;
		$this->tipo = strtolower($tipo);
	}

	public function getDadosSegmento($segmentoKey)
	{
		$dados = array();
		$layout = $this->tipo === 'remessa'
			? $this->layout->getRemessaLayout()
			: $this->layout->getRetornoLayout();
		$campos = $layout['detalhes'][$segmentoKey];
		foreach ($campos as $nome => $definicao) {
			$dados[$nome] = $this->obterValorCampo($definicao);
		}
		return $dados;
	}

	public function obterValorCampo(array $definicao)
	{
		if (1 !== preg_match(Picture::REGEX_VALID_FORMAT, $definicao['picture'], $tipo)) {
			throw new LinhaException('Erro ao obter valor de campo. Definição de campo inválida (picture).');
		}

		$inicio = $definicao['pos'][0] - 1;
		$tamanho1 = !empty($tipo['tamanho1']) ? (int)$tipo['tamanho1'] : 0;
		$tamanho2 = !empty($tipo['tamanho2']) ? (int)$tipo['tamanho2'] : 0;
		$tamanho = $tamanho1 + $tamanho2;
		$formato = $definicao['picture'];
		$opcoes = array();

		return Picture::decode(substr($this->linhaStr, $inicio, $tamanho), $formato, $opcoes);
	}

}