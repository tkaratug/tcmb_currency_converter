# TCMB Kur Çevirici
Bu sınıf, TCMB tarafından dağıtılan günlük döviz kurları üzerinden, istenilen kur bilgisini verir ve aynı zamanda çapraz kur dönüşümü yapar.

## Desteklenen Döviz Kodları
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

## Kurulum
```
$ composer require tkaratug/tcmb_currency_converter
```

## Kullanımı
```
include 'vendor/autoload.php';

use Currency\Converter;

$convert = new Converter(10); // 10 dakika önbellekte tutulur

// 1 USD'nin TL karşılığı olan alış fiyatı 
$convert->from('USD')->to('TRY')->amount(1)->selling()

// 1 USD'nin TL karşılığı olan satış fiyatı
$convert->from('USD')->to('TRY')->amount(1)->buying();

// Tarih
echo $convert->getDate();
```

## Changelog
#### v2.0.0
- PSR4 autoloading standardına uygun olarak yeniden yazıldı.
- Testler eklendi.

#### v1.0.1
- Önbellekleme sistemi eklendi. İsteğe bağlı olarak veriler, sınıfa parametre olarak verilen değer kadar önbellekte tutulabilir.
- convert() methoduna $type parametresi eklendi. Bu parametre 'BanknoteBuying', 'BanknoteSelling', 'ForexBuying' ve 'ForexSelling' değerlerini alabilir. Değer belirtilmezse varsayılan olarak 'ForexBuying' değerini alır.

