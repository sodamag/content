<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$csv = glob('csv/*.csv');
$csv = file_get_contents($csv[0]);

$code = str_getcsv($csv,"\n");

$colors = array(
'Черный'	=>	'blk',
'Бордовый'	=>	'bordo',
'Серый'	=>	'grey',
'Кремовый'	=>	'cream',
'Коричневый'	=>	'brown',
'Бежевый'	=>	'beige',
'Синий'	=>	'blue',
'Красный'	=>	'red',
'Зеленый'	=>	'green',
'Оранжевый'	=>	'orange',
'Белый '	=>	'white',
'Розовый'	=>	'pink',
'Желтый'	=>	'yellow',
'Кирпичный'	=>	'brick',
'Коралоовый'	=>	'corall',
'Горчичный'	=>	'mustard',
'Персиковый'	=>	'peach',
'Мятный'	=>	'mint',
'Темно-синий'	=>	'navy',
'Темно-коричневый'	=>	'dark-brown',
'Темно-серый'	=>	'dark-gray',
'Черно-белый'	=>	'blk&white',
'Светло-серый'	=>	'light-pink',
'Светло-коричневый'	=>	'light-brown',
'Молочный'	=>	'milk',
'Фиолетовый'	=>	'purple',
'Оливковый'	=>	'olive',
'Хаки'	=>	'khaki',
'Песочный'	=>	'beige',
'Сиреневый'	=>	'purple',
'Фуксия'	=>	'pink',
'Лиловый'	=>	'purple',
'Принт'	=>	'print'
);

$products = array();
foreach ($code as $key => $line) {
  if ($key == 0)
    continue;

  $line = iconv('windows-1251','utf-8', $line);
  $row = str_getcsv($line,";");
  $articul = explode('/',$row[1]);
  $articul = $articul[0];
  $c = @$colors[$row[9]];
  $products[$key][$articul]['articul'] = $articul;
  $products[$key][$articul]['color'] = $c;
  $products[$key][$articul]['img1'] = '';
  $products[$key][$articul]['img2'] = '';
  $products[$key][$articul]['img3'] = '';
}

$photos = glob('images/*');

$log = '<h2>Лог</h2>';

foreach ($photos as $photo) {
  $name = basename($photo);
  $params = explode('_',$name);

  $articul = $params[0];
  if (count($params)>2) {
    $color = $params[1];
    $i = $params[2];
  } else {
    $i = $params[1];
  }

  foreach ($products as $key => $product) {
    if (!empty($product[$articul])) {
      if ((isset($color) && $color == $product[$articul]['color']) || !isset($color)) {
        if (!empty($product[$articul]['img1']) && !empty($product[$articul]['img2'])) {
          $products[$key][$articul]['img3'] = $name;
        } elseif (!empty($product[$articul]['img1'])) {
          $products[$key][$articul]['img2'] = $name;
        } else {
          $products[$key][$articul]['img1'] = $name;
        }
        $log .= "Успех: {$articul} <br/>";
      } else {
        $log .= "Нет подходящего цвета у данного артикула: {$articul} <br/>";
      }
    }
  }

  unset($color);
  unset($i);
}

  // file_put_contents('sizes/'.$csv['name'][$kkey],$code);
  // print '<h1>ОК, все файлы в папке "sizes"</h1>';
  $lines = array();
  foreach ($products as $temp) {
    foreach ($temp as $product) {
      $lines[] = implode(';',$product);
    }
  }
  $code = implode("\n",$lines);
  
  header ( 'Content-type: text/csv' );
  header ( 'Content-Disposition: attachment; filename="orders.csv"' );
  print_r($code);

?>
