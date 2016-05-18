<?php
// Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

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