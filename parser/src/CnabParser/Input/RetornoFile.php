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
		$this->decode('header_arquivo', 0);
	}

	/**
	 * Processa trailer_arquivo
	 */
	protected function decodeTrailerArquivo()
	{
		$this->decode('trailer_arquivo', count($this->linhas) - 1);
	}

	protected function decodeLotes()
	{
		$lotes = $this->getLinhasLotes();
		print_r($lotes);
	}


	/**
	 * [decode description]
	 * @param  string $registro Registro a ser decodificado: header_arquivo, trailer_arquivo
	 * @return [type]           [description]
	 */
	protected function decode($registro = 'header_arquivo', $indiceLinha = 0)
	{
		$retornoLayout = $this->layout->getRetornoLayout();
		$definicoes = $retornoLayout[$registro];
		
		// linha referente ao registro
		$linhaTxt = $this->linhas[$indiceLinha];

		foreach ($definicoes as $campo => $definicao) {
			$valor = $this->obterValorCampoDaLinha($linhaTxt, $definicao);
			$this->model->{$registro}->{$campo} = $valor;
		}
	}
}