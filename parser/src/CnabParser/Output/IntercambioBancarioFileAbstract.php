<?php

namespace CnabParser\Output;

use CnabParser\Model\IntercambioBancarioAbstract;

use CnabParser\Format\Picture;

abstract class IntercambioBancarioFileAbstract
{

	/**
	 * Model to write
	 * @var CnabParser\Model\IntercambioBancarioAbstract
	 */
	protected $model;

	public function __construct(IntercambioBancarioAbstract $model)
	{
		$this->model = $model;
	}

	/**
	 * Write to file $path
	 * @param  string $path
	 * @return boolean
	 */
	abstract public function generate($path);

	protected function encode($fieldsDef, $modelSection)
	{
		$encoded = '';
		foreach ($fieldsDef as $field => $definition) {
			if (isset($modelSection->$field)) {
				$format = $definition['picture'];
				$encoded .= Picture::encode($modelSection->$field, $format, array());
			}
		}
		return $encoded;
	}
}