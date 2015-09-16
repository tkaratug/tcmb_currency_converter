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

## Kullanımı
```
$kur = new TCMB_currency();
print_r($kur->get_currency('EUR'));
echo $kur->convert('USD','EUR',100);
```
## Methodlar
### get_currency($code)
Bu method parametre olarak 3 karakterden oluşan döviz kodu alır. Verilen koda ait dövizin nakit alış, nakit satış, forex alış, forex satış değerlerini dizi olarak döndürür.

### convert($from, $to, $value)
Bu method parametre olarak çevrim yapılacak döviz kodlarını ve değeri alır. `$value` parametresine verilen değeri `$from` parametresine verilen dövizden, `$to` parametresine verilen döviz birimine çevirir.
