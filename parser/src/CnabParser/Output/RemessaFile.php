<?php

namespace CnabParser\Output;

class RemessaFile extends IntercambioBancarioFileAbstract
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

		file_put_contents($path, implode("\r\n", $data));
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

		return implode("\n", $encoded);
	}
}