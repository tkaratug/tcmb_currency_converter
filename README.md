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

## Changelog
#### v1.0.1
- Önbellekleme sistemi eklendi. İsteğe bağlı olarak veriler, sınıfa parametre olarak verilen değer kadar önbellekte tutulabilir.
- convert() methoduna $type parametresi eklendi. Bu parametre 'BanknoteBuying', 'BanknoteSelling', 'ForexBuying' ve 'ForexSelling' değerlerini alabilir. Değer belirtilmezse varsayılan olarak 'BanknoteBuying' değerini alır.

## Kullanımı
```
include 'currency.php';
$kur = new TCMB_currency(10); // 10 dakika önbellekte tutulur
echo 'Default (BanknoteBuying) : ' . $kur->convert('TRY','USD',25) . '<br>';
echo 'BanknoteBuying : ' . $kur->convert('TRY','USD',25, 'BanknoteBuying') . '<br>';
echo 'BanknoteSelling : ' . $kur->convert('TRY','USD',25, 'BanknoteSelling') . '<br>';
echo 'ForexBuying : ' . $kur->convert('TRY','USD',25, 'ForexBuying') . '<br>';
echo 'ForexSelling : ' . $kur->convert('TRY','USD',25, 'ForexSelling');
```
## Methodlar
### get_currency($code)
Bu method parametre olarak 3 karakterden oluşan döviz kodu alır. Verilen koda ait dövizin nakit alış, nakit satış, forex alış, forex satış değerlerini dizi olarak döndürür.

### convert($from, $to, $value, $type = 'BanknoteBuying')
Bu method parametre olarak çevrim yapılacak döviz kodlarını, çevrilecek miktarı ve sonuç tipini alır. `$value` parametresine verilen değeri `$from` parametresine verilen dövizden, `$to` parametresine verilen döviz birimine çevirir.
