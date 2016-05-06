<?php

namespace CnabParser;

use CnabParser\Parser\Layout;
use CnabParser\Model\Retorno;

abstract class IntercambioBancarioRetornoFileAbstract extends IntercambioBancarioFileAbstract
{
	/**
	 * @var CnabParser\Parser\Layout
	 */
	protected $layout;

	protected $path;

	protected $linhas;

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

		$this->model = new Retorno();
	}
}