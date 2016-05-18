<?php
// Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

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