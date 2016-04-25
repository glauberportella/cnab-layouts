<?php

namespace CnabParser\Parser;

use Symfony\Component\Yaml\Parser;

use CnabParser\Exception\LayoutException;

class Layout
{
	protected $yaml;

	protected $arquivo;

	public function __construct($arquivo)
	{
		$this->arquivo = $arquivo;
		$this->yaml = new Parser(file_get_contents($this->arquivo));
	}

	public function getRemessaLayout()
	{
		return !isset($this->yaml->remessa) 
			? throw new LayoutException('Falta seção "remessa" no arquivo de layout "'.$this->arquivo.'".')
			: $this->yaml->remessa;
	}

	public function getRetornoLayout()
	{
		return !isset($this->yaml->retorno) 
			? throw new LayoutException('Falta seção "retorno" no arquivo de layout "'.$this->arquivo.'".')
			: $this->yaml->retorno;
	}

	public function getVersao()
	{
		return !isset($this->yaml->retorno) 
			? null
			: $this->yaml->retorno;
	}

	public function getServico()
	{
		return !isset($this->yaml->servico) 
			? null
			: $this->yaml->servico;
	}
}