<?php

namespace CnabParser;

use CnabParser\IntercambioBancarioFileAbstract;
use CnabParser\IntercambioBancarioAbstract;
use CnabParser\Format\Picture;

abstract class IntercambioBancarioRemessaFileAbstract extends IntercambioBancarioFileAbstract
{
	public function __construct(IntercambioBancarioAbstract $model)
	{
		$this->model = $model;
	}
	
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