<html lang="pl">

<head>
    <title>URL Shortener</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link href="/public/style.css" rel="stylesheet">

</head>

<body class="body">
  <div class="wrapper">
    <div class="header">
      <h1><i class="fas fa-cut"></i> URL Shortener</h1>
    </div>

      <div class="page">
        <?php require_once("templates/pages/$page.php"); ?> <!-- w danym miejscu HTML zostanie wklejona zawartośc pliku $page.php, gdzie $page to nazwa pliku -->
      </div>
    </div>

    <div class="footer">
      <p>URL Shortener </p>
    </div>
  </div>
</body>

</html>