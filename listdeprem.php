<h1>Depremler</h1>

<?php

require_once("connection.php");

$SORGU = $DB->prepare("SELECT * FROM depremler ORDER BY id DESC");
$SORGU->execute();
// Kayıtları Getir
$KAYITLAR = $SORGU->fetchAll();

// print_r($KAYITLAR);

echo "<h2>Tablo 1</h2>";
echo "<table border='1' cellspacing='0' cellpadding='10' >";
echo "<tr>";
echo " <th>#</th>";
echo " <th>TARİH SAAT</th>";
echo " <th>ENLEM</th>";
echo " <th>BOYLAM</th>";
echo "</tr>";
foreach ($KAYITLAR as $key => $data) {
  //echo $data['tarih'] . " " . $data['enlem'] . " " . $data['boylam'] . "<br>";

  $tarih = date("d/m/Y, H:i:s", strtotime( $data['tarih'] ));

  echo "<tr>";
  echo " <td>{$data['id']}</td>";
  echo " <td>{$tarih}</td>";
  echo " <td>{$data['enlem']}</td>";
  echo " <td>{$data['boylam']}</td>";
  echo "</tr>";
}
echo "</table>";

?>

<h2>Tablo 2</h2>
<table border='1' cellspacing='0' cellpadding='10' >
<tr>
 <th>#</th>
 <th>TARİH SAAT</th>
 <th>ENLEM</th>
 <th>BOYLAM</th>
</tr>

<?php
  foreach ($KAYITLAR as $key => $data) {
  $tarih = date("d/m/Y, H:i:s", strtotime( $data['tarih'] ));
?>
  <tr>
   <td><?=$data['id']?>    </td>
   <td><?=$tarih?>         </td>
   <td><?=$data['enlem']?> </td>
   <td><?=$data['boylam']?></td>
  </tr>

<?php } ?>

</table>






<p>Bitti...</p>