<?php

namespace CnabParser\Input;

use CnabParser\IntercambioBancarioRetornoFileAbstract;
use CnabParser\Exception\RetornoException;
use CnabParser\Format\Picture;
use CnabParser\Model\Linha;

class RetornoFile extends IntercambioBancarioRetornoFileAbstract
{
	/**
	 * Para retorno o metodo em questao gera o modelo Retorno conforme layout
	 * @param  string $path Não necessario
	 * @return CnabParser\Model\Retorno
	 */
	public function generate($path = null)
	{
		$this->decodeHeaderArquivo();
		$this->decodeTrailerArquivo();
		$this->decodeLotes();
		return $this->model;
	}

	/**
	 * Processa header_arquivo
	 */
	protected function decodeHeaderArquivo()
	{
		$layout = $this->layout->getRetornoLayout();
		$headerArquivoDef = $layout['header_arquivo'];
		$linha = new Linha($this->linhas[0], $this->layout, 'retorno');
		foreach ($headerArquivoDef as $campo => $definicao) {
			$valor = $linha->obterValorCampo($definicao);
			$this->model->header_arquivo->{$campo} = $valor;
		}
	}

	/**
	 * Processa trailer_arquivo
	 */
	protected function decodeTrailerArquivo()
	{
		$layout = $this->layout->getRetornoLayout();
		$trailerArquivoDef = $layout['trailer_arquivo'];
		$linha = new Linha($this->linhas[count($this->linhas) - 1], $this->layout, 'retorno');
		foreach ($trailerArquivoDef as $campo => $definicao) {
			$valor = $linha->obterValorCampo($definicao);
			$this->model->trailer_arquivo->{$campo} = $valor;
		}
	}

	protected function decodeLotes()
	{
		$tipoLayout = $this->layout->getLayout();
		
		if (strtoupper($tipoLayout) === strtoupper('cnab240')) {
			$this->decodeLotesCnab240();
		} elseif (strtoupper($tipoLayout) === strtoupper('cnab400')) {
			$this->decodeLotesCnab400();
		}
	}

	private function decodeLotesCnab240()
	{
		$defTipoRegistro = array(
			'pos' => array(8, 8),
			'picture' => '9(1)',
		);

		$defCodigoLote = array(
			'pos' => array(4, 7),
			'picture' => '9(4)',
		);

		$defCodigoSegmento = array(
			'pos' => array(14, 14),
			'picture' => 'X(1)',
		);

		$defNumeroRegistro = array(
			'pos' => array(9, 13),
			'picture' => '9(5)',
		);

		$indiceDetalhe = 0;
		$ultimoCodigoSegmentoLayout = $this->layout->getUltimoCodigoSegmentoRetorno();
		
		foreach ($this->linhas as $linhaStr) {
			$linha = new Linha($linhaStr, $this->layout, 'retorno');
			$tipoRegistro = (int)$linha->obterValorCampo($defTipoRegistro);
			if ($tipoRegistro !== IntercambioBancarioRetornoFileAbstract::REGISTRO_HEADER_LOTE && 
				$tipoRegistro !== IntercambioBancarioRetornoFileAbstract::REGISTRO_DETALHES) {
				continue;
			}

			if ($tipoRegistro === 1) {
				$codigoLote = $linha->obterValorCampo($defCodigoLote);
				$this->model->lotes[$codigoLote] = array();
			} elseif ($tipoRegistro === 3) {
				$codigoSegmento = $linha->obterValorCampo($defCodigoSegmento);
				$numeroRegistro = $linha->obterValorCampo($defNumeroRegistro);
				
				$chaveSegmento = 'segmento_'.strtolower($codigoSegmento);

				$this->model->lotes[$codigoLote][$indiceDetalhe][$codigoSegmento] = $linha->getDadosSegmento($chaveSegmento);

				if (strtolower($codigoSegmento) === strtolower($ultimoCodigoSegmentoLayout)) {
					$indiceDetalhe++;
				}
			}
		}
	}

	private function decodeLotesCnab400()
	{

	}
}