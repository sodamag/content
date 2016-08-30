<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if(!function_exists('str_getcsv')) {
    function str_getcsv($input, $delimiter = ',', $enclosure = '"') {

        if( ! preg_match("/[$enclosure]/", $input) ) {
          return (array)preg_replace(array("/^\\s*/", "/\\s*$/"), '', explode($delimiter, $input));
        }

        $token = "##"; $token2 = "::";
        //alternate tokens "\034\034", "\035\035", "%%";
        $t1 = preg_replace(array("/\\\[$enclosure]/", "/$enclosure{2}/",
             "/[$enclosure]\\s*[$delimiter]\\s*[$enclosure]\\s*/", "/\\s*[$enclosure]\\s*/"),
             array($token2, $token2, $token, $token), trim(trim(trim($input), $enclosure)));

        $a = explode($token, $t1);
        foreach($a as $k=>$v) {
            if ( preg_match("/^{$delimiter}/", $v) || preg_match("/{$delimiter}$/", $v) ) {
                $a[$k] = trim($v, $delimiter); $a[$k] = preg_replace("/$delimiter/", "$token", $a[$k]); }
        }
        $a = explode($token, implode($token, $a));
        return (array)preg_replace(array("/^\\s/", "/\\s$/", "/$token2/"), array('', '', $enclosure), $a);

    }
}


$csv = @$_FILES['csv'];
foreach ($csv['tmp_name'] as $kkey => $tmp) {
  // if ($csv['type'][$kkey] != 'text/csv') {
  //   print $csv['name'][$kkey].' - не удалось сконвертировать. Не CSV.<br/>';
  //   continue;
  // }
  $code = file_get_contents($tmp);
  $code = str_getcsv($code,"\n");
  foreach ($code as $key => $str) {
    if ($key == 0)
      continue;
    $str = str_getcsv($str,';');
    $temp = explode('/',$str[7]);
    if (count($temp) > 1) {
      foreach ($temp as $tkey => $val) {
        $str[7] = $val;
        if ($tkey == 0) {
          $code[$key] = implode(';',$str);
        } else {
          $code[] = implode(';',$str);
        }
      }
    }
    $temp2 = explode('/',$str[9]);
    if (count($temp2) > 1) {
      foreach ($temp2 as $tkey2 => $val2) {
        $str[9] = $val2;
        if ($tkey2 == 0) {
          $code[$key] = implode(';',$str);
        } else {
          $code[] = implode(';',$str);
        }
      }
    }
  }
  $code = implode("\n",$code);
  file_put_contents('sizes/'.$csv['name'][$kkey],$code);
  print '<h1>ОК, все файлы в папке "sizes"</h1>';
}

?>
