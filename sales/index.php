<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title></title>
</head>
<body>
  <h1>Скидки</h1>
  <form method="POST" action="save" enctype="multipart/form-data">
    <label>
      <p>Исходный CSV</p>
      <input type="file" name="csv" />
    </label>
    <label>
      <p>Скидки</p>
    <input type="file" name="sales" />
  </label>

  <br/>
  <br/>
    <input type="submit" value="Загрузить" />
  </form>
</body>
</html>
