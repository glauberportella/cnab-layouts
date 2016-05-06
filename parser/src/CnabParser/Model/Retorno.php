<?php

namespace CnabParser\Model;

use StdClass AS DataContainer;

class Retorno
{
	/**
	 * @var DataContainer
	 */
	public $header_arquivo;

	/**
	 * @var DataContainer
	 */
	public $trailer_arquivo;

	/**
	 * @var Array of DataContainer (header_lote(1),detalhes(1)(n),trailer_lote(1) ... header_lote(m),detalhes(1)(n),trailer_lote(m))
	 */
	public $lotes;

	public function __construct()
	{
		$this->header_arquivo = new DataContainer();
		$this->trailer_arquivo = new DataContainer();
		$this->lotes = array();
	}
}