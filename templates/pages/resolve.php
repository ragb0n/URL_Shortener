<div class="resolve">
  Prosze czekac, trwa przekierowanie
  <?php $url = $params['url'] ?? null; //do zmiennej $url zapisuje wartośc klusza url tablicy $params, przekazanej z Controller.php jako $viewParams
  if($url)
  {
    $beforeURL = $url['beforeURL']; //pod kluczem 'url' tablicy $params znajduje się tablica z wynikami zapytania do bazy, dlatego do $beforeURL zapisujemy wartośc kolejnej kolumny 'beforeURL'
    header("Location: $beforeURL"); //przekierowanie na stronę, której adres znajduje się w $beforeURL
    die();
  } else
  ?>
</div>