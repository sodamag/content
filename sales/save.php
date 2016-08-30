<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$csv = @$_FILES['csv'];
$sales = @$_FILES['sales'];
$tmp = $csv['tmp_name'];

$sales = file_get_contents($sales['tmp_name']);
$sales = str_getcsv($sales,"\n");

$temp = array();

foreach ($sales as $k => $s) {
  if ($k == 0)
    continue;
  $s = str_getcsv($s,';');
  $temp[$s[0]] =  preg_replace("/[^0-9]/", '', $s[1]);
}


$code = file_get_contents($tmp);
$code = str_getcsv($code,"\n");
//скидки = 22
//акртикул = 1
foreach ($code as $key => $str) {
  if ($key == 0)
    continue;

  $str = str_getcsv($str,';');
  if (array_key_exists($str[1], $temp)) {
    $str[22] = $temp[$str[1]];
  }
  foreach($str as $a => $b) {
    $str[$a] = '"'.$b.'"';
  }
  $str = implode(";",$str);
  $code[$key] = $str;
}

  $code = implode("\n",$code);

  header ( 'Content-type: text/csv' );
  header ( 'Content-Disposition: attachment; filename="orders.csv"' );
  print_r($code);
  // file_put_contents('sizes/'.$csv['name'][$kkey],$code);
  // print '<h1>ОК, все файлы в папке "sizes"</h1>';


?>
