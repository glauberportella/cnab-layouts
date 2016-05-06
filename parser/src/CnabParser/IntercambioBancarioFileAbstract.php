<?php

namespace CnabParser;

use CnabParser\IntercambioBancarioAbstract;

abstract class IntercambioBancarioFileAbstract
{
	/**
	 * Model to write
	 * @var CnabParser\Model\IntercambioBancarioAbstract
	 */
	protected $model;

	/**
	 * Write to file $path
	 * @param  string $path
	 * @return boolean
	 */
	abstract public function generate($path);
}