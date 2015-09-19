<?php
/**
 * TCMB_Currency Class
 *
 * TCMB tarafından açıklanan günlük kur bilgilerini erişip çevrim yapabilen php sınıfı.
 * NOT: Çevrim işlemi sonucu "alış" rakamları üzerinden yapılır.
 *
 * =========================
 * DÖVİZ KODLARI
 * TRY [TÜRK LİRASI]
 * USD [AMERİKAN DOLARI]
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
 * =========================
 * 
 * =========================
 * Changelog v1.0.1
 * 1- Önbellekleme sistemi eklendi. İsteğe bağlı olarak veriler, sınıfa parametre olarak verilen değer kadar önbellekte tutulabilir.
 * 	  Örnek: $kur = new TCMB_currency(10); 	(XML dosyasındaki veriler 10 dk boyunca önbellekte tutulur.)
 *
 * 2- convert() methoduna $type parametresi eklendi. Bu parametre 'BanknoteBuying', 'BanknoteSelling', 'ForexBuying' ve 'ForexSelling' değerlerini alabilir. 
 *    Değer belirtilmezse varsayılan olarak 'ForexBuying' değerini alır.
 * ========================= 
 *
 * @author	Turan Karatuğ
 * @version 	v1.0.1
 * @copyright 	16.09.2015
 */

class TCMB_Currency
{
	// Döviz Kodu
	private $currencyCode;
	
	// Okunan XML kaynağı
	private $xml;
	
	// Döviz Dizisi
	private $currency = array();
	
	function __construct($cache = 0)
	{
		// Kurlar Çekiliyor
		$this->get_tcmb_xml($cache);
		
		// Çekilen Kur Bilgileri Diziye Atılıyor
		$this->sort_data();
	}
	
	/**
	 * TCMB XML dosyası okunuyor.
	 * @return void
	 */
	private function get_tcmb_xml($cache = 0)
	{
		if($cache > 0) {
			$cacheName 	= 'currency_feed.xml';
			$cacheAge 	= $cache*60;
			if(!file_exists($cacheName) || filemtime($cacheName) > time() + $cacheAge) {
				$contents = file_get_contents('http://www.tcmb.gov.tr/kurlar/today.xml');
  				file_put_contents($cacheName, $contents);
			}
			$this->xml = simplexml_load_file($cacheName);
		} else {
			$this->xml = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml");
		}
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
	 * @param $type 	string 	(BanknoteBuying|BanknoteSelling|ForexBuying|ForexSelling)
	 * @return decimal
	 */
	public function convert($from, $to, $value, $type = 'ForexBuying')
	{
		$deger 	= $value * $this->get_currency($from)[$type];
		$sonuc	= $deger / $this->get_currency($to)[$type];
		return round($sonuc,4);
	}
	
}

?>
