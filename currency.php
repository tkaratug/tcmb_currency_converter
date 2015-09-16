<?php
/**
 * TCMB_Currency Class
 *
 * TCMB tarafından açıklanan günlük kur bilgilerini erişip çevrim yapabilen php sınıfı.
 * NOT: Çevrim işlemi sonucu "satış" rakamları üzerinden yapılır.
 *
 * DÖVİZ KODLARI
 * USD [Amerikan Doları]
 * AUD [AVUSTRALYA DOLARI]
 * DKK [DANİMARKA KRONU]
 * EUR [EURO]
 * GBP [İNGİLİZ STERLİNİ]
 * CHF [İSVİÇRE FRANGI]
 * SEK [İSVEÇ KRONU]
 * CAD [KANADA DOLARI]
 * KWD [KUVEYT DİNARI]
 * NOK [NORVEÇ KRONU]
 * SAR [SUUDİ ARABİSTAN RİYALİ]
 * JPY [JAPON YENİ]
 * BGN [BULGAR LEVASI]
 * RON [RUMEN LEYİ]
 * RUB [RUS RUBLESİ]
 * IRR [İRAN RİYALİ]
 * CNY [ÇİN YUANI]
 * PKR [PAKİSTAN RUPİSİ]
 * 
 * @author	Turan Karatuğ
 * @version 	v1.0
 * @date 	16.09.2015
 */

class TCMB_Currency
{
	// Döviz Kodu
	private $currencyCode;
	
	// Okunan XML kaynağı
	private $xml;
	
	// Döviz Dizisi
	private $currency = array();
	
	function __construct()
	{
		// Kurlar Çekiliyor
		$this->get_tcmb_xml();
		
		// Çekilen Kur Bilgileri Diziye Atılıyor
		$this->sort_data();
	}
	
	/**
	 * TCMB XML dosyası okunuyor.
	 * @return void
	 */
	private function get_tcmb_xml()
	{
		$this->xml = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml");
	}
	
	/**
	 * Okunan XML dosyasındaki veriler diziye atılıyor
	 * @return void
	 */
	private function sort_data()
	{
		foreach($this->xml->Currency as $group => $item)
		{	
			$this->currencyCode = $item['CurrencyCode'];
			foreach($item as $key => $item)
			{
				$this->currency["$this->currencyCode"]["$key"] = "$item";
			}
		}
		
		// Türk Lirası Ekleniyor
		$this->currency['TRY']['Unit'] 			= 1;
		$this->currency['TRY']['Isim'] 			= 'TÜRK LİRASI';
		$this->currency['TRY']['CurrencyName'] 		= 'TRY';
		$this->currency['TRY']['ForexBuying']		= 1;
		$this->currency['TRY']['ForexSelling']		= 1;
		$this->currency['TRY']['BanknoteBuying']	= 1;
		$this->currency['TRY']['BanknoteSelling']	= 1;
	}
	
	/**
	 * Döviz Bilgilerini Alma
	 * @param $code	int	(Döviz kodu)
	 * @return array
	 */
	public function get_currency($code)
	{
		return $this->currency[$code];
	}
	
	/**
	 * Döviz Çevirici
	 * @param $from		int
	 * @param $to 		int
	 * @param $value	int
	 * @return decimal
	 */
	public function convert($from, $to, $value)
	{
		$deger 	= $value * $this->get_currency($from)['BanknoteBuying'];
		$sonuc	= $deger / $this->get_currency($to)['BanknoteBuying'];
		return round($sonuc,4);
	}
	
}

?>
