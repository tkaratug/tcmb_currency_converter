<?php

include 'currency.php';

$kur = new TCMB_currency(10); // 10 dakika önbellekte tutulur

echo 'Default (ForexBuying) : ' . $kur->convert('TRY','USD',25) . '<br>';
echo 'BanknoteBuying : ' . $kur->convert('TRY','USD',25, 'BanknoteBuying') . '<br>';
echo 'BanknoteSelling : ' . $kur->convert('TRY','USD',25, 'BanknoteSelling') . '<br>';
echo 'ForexBuying : ' . $kur->convert('TRY','USD',25, 'ForexBuying') . '<br>';
echo 'ForexSelling : ' . $kur->convert('TRY','USD',25, 'ForexSelling');

// Tarih
echo $kur->getDatae();

?>
