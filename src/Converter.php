<?php

namespace Currency;

use \SimpleXMLElement;

class Converter
{
    private string $url = 'http://www.tcmb.gov.tr/kurlar/today.xml';

    private string $from;

    private string $to;

    private $amount = 1;

    private SimpleXMLElement $xml;

    private array $currency = [];

    private int $cache;

    /**
     * Constructor.
     * 
     * @param int $cache
     */
    public function __construct(int $cache = 0)
    {
        $this->cache = $cache;
        $this->getRates();
        $this->parseRates();
    }

    /**
     * Set the currency which will be converted from.
     * 
     * @param string $from
     * @return $this
     */
    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set the currency which will be converted to.
     * 
     * @param string $to
     * @return $this
     */
    public function to(string $to): self
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Set the amount which will be converted.
     * 
     * @param int|float $amount
     * @return $this
     */
    public function amount($amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get selling price.
     * 
     * @return float
     */
    public function selling(): float
    {
        return $this->convert('BanknoteSelling');
    }

    /**
     * Get buying price.
     * 
     * @return float
     */
    public function buying(): float
    {
        return $this->convert('BanknoteBuying');
    }

    /**
     * Get date.
     * 
     * @return string
     */
    public function getDate(): string
    {
        $output = json_decode(json_encode($this->xml), true);
		return $output['@attributes']['Tarih'];
    }

    /**
     * Convert.
     * 
     * @param string $type
     * @return float
     */
    private function convert(string $type): float
    {
        if (empty($this->from)) {
            throw new \Exception('The currency which will be converted from is not set');
        }

        if (!isset($this->currency[$this->from])) {
            throw new \Exception('The currency which will be converted from is not found');
        }

        if (empty($this->to)) {
            throw new \Exception('The currency which will be converted to is not set');
        }

        if (!isset($this->currency[$this->to])) {
            throw new \Exception('The currency which will be converted to is not found');
        }

        $deger 	= $this->amount * $this->currency[$this->from][$type];
        $sonuc	= $deger / $this->currency[$this->to][$type];
        return round($sonuc, 4);
    }

    /**
     * Get currency rates from TCMB.
     * 
     * @return void
     */
    private function getRates(): void
    {
        if ($this->cache > 0) {
            $cacheName 	= 'currency_feed.xml';
            $cacheAge 	= $this->cache * 60;

            if (!file_exists($cacheName) || filemtime($cacheName) > time() + $cacheAge) {
				$contents = file_get_contents($this->url);
  				file_put_contents($cacheName, $contents);
            }
            
            $this->xml = simplexml_load_file($cacheName);
        } else {
            $this->xml = simplexml_load_file($this->url);
        }
    }

    /**
     * Parse rates.
     * 
     * @return void
     */
    private function parseRates(): void
    {
        foreach($this->xml->Currency as $group => $item)
		{	
			$currencyCode = $item['CurrencyCode'];
			foreach($item as $key => $item)
			{
				$this->currency["$currencyCode"]["$key"] = "$item";
			}
        }
        
        // Türk Lirası Ekleniyor
		$this->currency['TRY']['Unit'] 				= 1;
		$this->currency['TRY']['Isim'] 				= 'TÜRK LİRASI';
		$this->currency['TRY']['CurrencyName'] 		= 'TRY';
		$this->currency['TRY']['ForexBuying']		= 1;
		$this->currency['TRY']['ForexSelling']		= 1;
		$this->currency['TRY']['BanknoteBuying']	= 1;
		$this->currency['TRY']['BanknoteSelling']	= 1;
    }
}
