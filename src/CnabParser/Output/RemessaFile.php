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

namespace CnabParser\Output;

use CnabParser\IntercambioBancarioRemessaFileAbstract;

class RemessaFile extends IntercambioBancarioRemessaFileAbstract
{
	public function generate($path)
	{
		// header arquivo
		$headerArquivo = $this->encodeHeaderArquivo();

		// header lote
		$headerLote = $this->encodeHeaderLote();

		// trailer lote
		$trailerLote = $this->encodeTrailerLote();

		// trailer arquivo
		$trailerArquivo = $this->encodeTrailerArquivo();
		
		// segmentos (detalhes)
		$detalhes = $this->encodeDetalhes();

		$data = array(
			$headerArquivo,
			$headerLote,
			$detalhes,
			$trailerLote,
			$trailerArquivo,
		);

		$data = implode("\r\n", $data);
		$data .= "\r\n";

		file_put_contents($path, $data);
	}

	protected function encodeHeaderArquivo()
	{
		if (!isset($this->model->header_arquivo))
			return;

		$layout = $this->model->getLayout();
		$layoutRemessa = $layout->getRemessaLayout();
		return $this->encode($layoutRemessa['header_arquivo'], $this->model->header_arquivo);
	}

	protected function encodeHeaderLote()
	{
		if (!isset($this->model->header_lote))
			return;

		$layout = $this->model->getLayout();
		$layoutRemessa = $layout->getRemessaLayout();
		return $this->encode($layoutRemessa['header_lote'], $this->model->header_lote);
	}

	protected function encodeTrailerLote()
	{
		if (!isset($this->model->trailer_lote))
			return;

		$layout = $this->model->getLayout();
		$layoutRemessa = $layout->getRemessaLayout();
		return $this->encode($layoutRemessa['trailer_lote'], $this->model->trailer_lote);
	}

	protected function encodeTrailerArquivo()
	{
		if (!isset($this->model->trailer_arquivo))
			return;

		$layout = $this->model->getLayout();
		$layoutRemessa = $layout->getRemessaLayout();
		return $this->encode($layoutRemessa['trailer_arquivo'], $this->model->trailer_arquivo);
	}

	protected function encodeDetalhes()
	{
		if (!isset($this->model->detalhes))
			return;

		$layout = $this->model->getLayout();
		$layoutRemessa = $layout->getRemessaLayout();

		$encoded = array();

		foreach ($this->model->detalhes as $detalhe) {
			foreach ($detalhe as $segmento => $obj) {
				$segmentoEncoded = $this->encode($layoutRemessa['detalhes'][$segmento], $detalhe->$segmento);
				$encoded[] = $segmentoEncoded;
			}
		}

		return implode("\r\n", $encoded);
	}
}