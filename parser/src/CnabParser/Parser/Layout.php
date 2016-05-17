<?php

namespace CnabParser\Parser;

use CnabParser\Exception\LayoutException;

use Symfony\Component\Yaml\Yaml;

class Layout
{
	protected $config;

	protected $arquivo;

	public function __construct($arquivo)
	{
		$this->arquivo = $arquivo;
		$this->config = Yaml::parse(file_get_contents($arquivo));
	}

	public function getRemessaLayout()
	{
		if (!isset($this->config['remessa'])) {
			throw new LayoutException('Falta seção "remessa" no arquivo de layout "'.$this->arquivo.'".');
		}

		return $this->config['remessa'];
	}

	public function getRetornoLayout()
	{
		if (!isset($this->config['retorno'])) {
			throw new LayoutException('Falta seção "retorno" no arquivo de layout "'.$this->arquivo.'".');
		}
		
		return $this->config['retorno'];
	}

	public function getVersao()
	{
		return !isset($this->config['retorno']) 
			? null
			: $this->config['retorno'];
	}

	public function getServico()
	{
		return !isset($this->config['servico']) 
			? null
			: $this->config['servico'];
	}

	public function getLayout()
	{
		return !isset($this->config['layout']) 
			? null
			: $this->config['layout'];
	}

	public function getUltimoCodigoSegmentoRetorno()
	{
		$layout = $this->getRetornoLayout();
		$segmentos = array_keys($layout['detalhes']);
		$ultimoSegmento = $segmentos[count($segmentos) - 1];
		$partes = explode('_', $ultimoSegmento);
		return strtolower($partes[count($partes) - 1]);
	}
}