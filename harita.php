<!DOCTYPE html>
<html lang="tr">
<head>

   <title>Deprem Haritası</title>

   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

   <style>
      html, body {
         height: 100%;
         margin: 0;
      }
      .leaflet-container {
         height: 400px;
         width: 600px;
         max-width: 100%;
         max-height: 100%;
      }
   </style>


</head>
<body>


<h3>Deprem Haritası</h3>
<div id="map" style="width: 800px; height: 400px;"></div>

<ul>
   <li><a href='harita.php'>Son 10 Deprem</a></li>

<?php

      // Bağlan
      require_once("connection.php");


      $SORGU = $DB->prepare("SELECT DISTINCT DATE_FORMAT(tarih, '%Y-%m-%d') as tarih
                             FROM depremler ORDER BY 1 DESC LIMIT 2");
      $SORGU->execute();
      $KAYITLAR = $SORGU->fetchAll();
      // Gelen veriyi kullan
      foreach ($KAYITLAR as $key => $data) {
         echo "<li><a href='harita.php?tarih={$data['tarih']}'>{$data['tarih']}</a></li>\n";
      }
?>

</ul>

<script>

   var map = L.map('map').setView([39.971773, 32.879939], 5);

   var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 18,
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
         'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1
   }).addTo(map);


   <?php

      // Verileri çek
      if( isset($_GET["tarih"]) ) {
         $TARIH = $_GET["tarih"];
         $SORGU = $DB->prepare("SELECT * FROM depremler
                     WHERE tarih BETWEEN '$TARIH 00:00:00' and '$TARIH 23:59:59'
                     ORDER BY id DESC");
      } else {
         $SORGU = $DB->prepare("SELECT * FROM depremler ORDER BY id DESC LIMIT 10");
      }


      $SORGU->execute();
      $KAYITLAR = $SORGU->fetchAll();
      // Gelen veriyi kullan
      foreach ($KAYITLAR as $key => $data) {
         echo "var marker = L.marker([{$data['enlem']}, {$data['boylam']}]).addTo(map);\n";
      }

   ?>

   // var marker = L.marker([37.1352, 29.1177]).addTo(map);
   // var marker = L.marker([38.8798, 43.5740]).addTo(map);
   // var marker = L.marker([39.7240, 23.8142]).addTo(map);

</script>



</body>
</html>
