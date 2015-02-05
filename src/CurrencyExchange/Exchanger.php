<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

use CurrencyExchange\Factory\ServiceFactory;
use CurrencyExchange\Currency;
use InvalidArgumentException;

/**
 * Main class that retrieve exchange rates from the current web service set
 * 
 * @package CurrencyExchange
 */
class Exchanger
{
	/**
	 * @var CurrencyExchange\Service\ServiceAbstract Current exchange service
	 */
	protected $_service = null;

	/**
	 * @var CurrencyExchange\Currency\CurrencyData Currency's data handler
	 */
	protected $_currencyData = null;

	/**
	 * Constructor invokes setService
	 * 
	 * @param object|string|null $method The exchange service used for getting exchange rate
	 */
	public function __construct($service = null, $currencyDataAdapter = null)
	{
		$this->_currencyData = new Currency\CurrencyData();
		$this->_currencyData->setAdapter($currencyDataAdapter);
		$this->setService($service);
	}

	/**
	 * Returns service object
	 * 
	 * @return CurrencyExchange\Service\ServiceAbstract
	 */
	public function getService()
	{
		return $this->_service;
	}

	/**
	 * Invokes factory method to instantiates a new Exchange Service
	 * 
	 * @param object|string|null $service The exchange service used for getting exchange rate
	 * @return CurrencyExchange\Exchanger
	 */
	public function setService($service = null)
	{
		$this->_service = ServiceFactory::factory($service);
		return $this;
	}

	/**
	 * Retrive current currency data handler object
	 * 
	 * @return CurrencyExchange\Currency\CurrencyData
	 */
	public function getCurrencyData()
	{
		return $this->_currencyData;
	}

	/**
	 * Set proxy to HttpClient object
	 * 
	 * @param string $proxy The proxy string in form host:port
	 * @return CurrencyExchange\Exchanger
	 */
	public function setProxy($proxy)
	{
		$this->_service->getHttpClient()->setProxy($proxy);
		return $this;
	}

	/**
	 * Get current exchange rate of selected method
	 * 
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @throws InvalidArgumentException
	 * @return float
	 */
	public function getExchangeRate($fromCode, $toCode)
	{
		if (!$this->_currencyData->isValid($fromCode)) {
			throw new InvalidArgumentException('Currency ' . $fromCode . ' is not a valid currency');
		}

		if (!$this->_currencyData->isValid($toCode)) {
			throw new InvalidArgumentException('Currency ' . $toCode . ' is not a valid currency');
		}

		$this->_service
			->getUri()
			->setFromCurrency(new Currency\Currency($fromCode))
			->setToCurrency(new Currency\Currency($toCode));

		return $this->_service->getExchangeRate();
	}

	/**
	 * Retrieve the exchange rate, and it multiplies to the $amount parameter.
	 * 
	 * @param float $amount The amount to exchange
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @return float
	 */
	public function exchange($amount, $fromCode, $toCode)
	{
		return (float) $this->getExchangeRate($fromCode, $toCode) * (float) $amount;
	}
}
