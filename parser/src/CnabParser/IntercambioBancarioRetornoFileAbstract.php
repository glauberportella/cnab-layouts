<?php

namespace CnabParser;

use CnabParser\Parser\Layout;
use CnabParser\Model\Retorno;
use CnabParser\Format\Picture;

abstract class IntercambioBancarioRetornoFileAbstract extends IntercambioBancarioFileAbstract
{
	const REGISTRO_HEADER_ARQUIVO = 0;
	const REGISTRO_HEADER_LOTE = 1;
	const REGISTRO_DETALHES = 3;
	const REGISTRO_TRAILER_LOTE = 5;
	const REGISTRO_TRAILER_ARQUIVO = 9;

	/**
	 * @var CnabParser\Parser\Layout
	 */
	protected $layout;

	protected $path;

	protected $linhas;

	/**
	 * Total de lotes em um arquivo
	 * @var integer
	 */
	protected $totalLotes;

	/**
	 * [__construct description]
	 * @param Layout $layout Layout do retorno
	 * @param string $path   Caminho do arquivo de retorno a ser processado
	 */
	public function __construct(Layout $layout, $path)
	{
		$this->layout = $layout;
		$this->path = $path;

		$this->linhas = file($this->path, FILE_IGNORE_NEW_LINES);
		if (false === $this->linhas) {
			throw new RetornoException('Falha ao ler linhas do arquivo de retorno "'.$this->path.'".');
		}

		$this->calculaTotalLotes();

		$this->model = new Retorno();
	}

	public function getTotalLotes()
	{
		return $this->totalLotes;
	}

	/**
	 * Obtem as linhas de lotes
	 * @return [type] [description]
	 */
	protected function getLinhasLotes()
	{
		$layout = $this->layout->getLayout();

		if (strtoupper($layout) === strtoupper('cnab240')) {
			// conforme cnab240 febraban definicao do campo tipo registro
			$definicaoTipoRegistro = array(
				'pos' => array(8, 8),
				'picture' => '9(6)'
			);
			// conforme cnab240 febraban definicao do campo codigo registro (lote servico)
			$definicaoCodigoRegistro = array(
				'pos' => array(4, 7),
				'picture' => '9(4)'
			);

			$indiceLinhaHeaderLote = -1;
			$indiceLinhaTrailerLote = -1;
			$lotes = array();
			$j = 1;
			for ($i = 0; $i < count($this->linhas); $i += $j) {
				$t1 = (int)$this->obterValorCampoDaLinha($this->linhas[$i], $definicaoTipoRegistro);
				$codigo = (int)$this->obterValorCampoDaLinha($this->linhas[$i], $definicaoCodigoRegistro);

				if (self::REGISTRO_HEADER_LOTE === $t1) {
					$indiceLinhaHeaderLote = $i;
					for ($j = $i + 1; $j < count($this->linhas); $j++) {
						$t2 = (int)$this->obterValorCampoDaLinha($this->linhas[$j], $definicaoTipoRegistro);
						$c2 = (int)$this->obterValorCampoDaLinha($this->linhas[$j], $definicaoCodigoRegistro);
						if (self::REGISTRO_TRAILER_LOTE === $t2 && $c2 === $codigo) {
							$indiceLinhaTrailerLote = $j;
							$len = $indiceLinhaTrailerLote - $indiceLinhaHeaderLote + 1;
							$lotes[$codigo] = array_slice($this->linhas, $indiceLinhaHeaderLote, $len);
							$indiceLinhaHeaderLote = -1;
							$indiceLinhaTrailerLote = -1;
							break;
						}
					}
				}
			}

			return $lotes;
		}

		return array();
	}

	protected function calculaTotalLotes()
	{
		$this->totalLotes = 1;

		$layout = $this->layout->getLayout();
		if (strtoupper($layout) === strtoupper('cnab240')) {
			// conforme cnab240 febraban
			$definicao = array(
				'pos' => array(18, 23),
				'picture' => '9(6)'
			);
			$linhaTrailerArquivo = $this->linhas[count($this->linhas) - 1];
			$this->totalLotes = (int)$this->obterValorCampoDaLinha($linhaTrailerArquivo, $definicao);
		}

		return $this->totalLotes;
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