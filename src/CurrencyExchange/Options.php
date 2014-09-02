<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

use CurrencyExchange\Exception;

/**
 * Class for handling general options
 * 
 * @package CurrencyExchange
 */
class Options
{
	/**
	 * @var array
	 */
	protected $_options;

	/**
	 * Initialize option's array
	 */
	public function __construct()
	{
		$this->_options = array();
	}

	/**
	 * Returns all options
	 * 
	 * @return array
	 */
	public function getOptions()
	{
		return $this->_options;
	}

	/**
	 * Retrieve one option
	 * 
	 * @param mixed $option
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return mixed
	 */
	public function getOption($option)
	{
		if (!is_scalar($option)) {
			throw new Exception\InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (isset($this->_options[$option])) {
			return $this->_options[$option];
		}

		return false;
	}

	/**
	 * Add option
	 * 
	 * @param mixed $option
	 * @param mixed $value
	 * @param boolean $replace if true, the existent value of $option will be replaced
	 * @return CurrencyExchange\Options
	 */
	public function addOption($option, $value, $replace = false)
	{
		$replace = (bool) $replace;

		if (!array_key_exists($option, $this->_options) || $replace) {
			$this->_options[$option] = $value;
		}

		return $this;
	}

	/**
	 * Remove option
	 * 
	 * @param mixed $option
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Options
	 */
	public function removeOption($option)
	{
		if (!is_scalar($option)) {
			throw new Exception\InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (array_key_exists($option, $this->_options)) {
			unset($this->_options[$option]);
		}

		return $this;
	}

	/**
	 * Sets array of options
	 * 
	 * @param array $options
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Options
	 */
	public function setOptions(array $options)
	{
		foreach ($options as $option => $optionValue) {
			if (!is_scalar($option)) {
				throw new Exception\InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
			}
		}

		$this->_options = $options;
		return $this;
	}

	/**
	 * Resets options
	 * 
	 * @return CurrencyExchange\Options
	 */
	public function resetOptions()
	{
		$this->_options = array();
		return $this;
	}
}