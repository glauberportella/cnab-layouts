<?php

namespace CnabParser;

use CnabParser\Parser\Layout;

abstract class IntercambioBancarioAbstract implements \JsonSerializable
{
	/**
	 * the data
	 * @var array
	 */
	protected $data;

	/**
	 * @var CnabParser\Parser\Layout
	 */
	protected $layout;

    public function __construct(Layout $layout)
    {
        $this->layout = $layout;
    }

	/**
	 * @return CnabParser\Parser\Layout
	 */
	public function getLayout()
	{
		return $this->layout;
	}

    public function jsonSerialize()
    {
        return $this->data;
    }

	public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }
}