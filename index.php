<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title></title>
</head>
<body>
  <h1>Размеры</h1>
  <form method="POST" action="sizes.php" enctype="multipart/form-data">
    <input type="file" name="csv[]" multiple="multiple" />
    <input type="submit" value="Загрузить" />
  </form>
</body>
</html>
