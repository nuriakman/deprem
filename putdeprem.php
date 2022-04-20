<?php
/*

  # CRON İÇERİĞİ:   crontan -e
  # Her 5 dakikada bir deprem verisini Kandilli'den çek ve php ile veritabanına yaz
  x/5 * * * * bash /var/www/html/deprem/getDeprem.sh

*/

//echo "GELEN VERI:";
//print_r($_FILES);

$DosyaAdi = $_FILES['deprem_data']['tmp_name'];
//$DosyaIcerigi = file_get_contents($DosyaAdi);
/*
$DosyaIcerigi = "
2022.04.19 23:56:26 37.1352 29.1177
2022.04.19 23:41:51 38.8798 43.5740
2022.04.19 22:56:33 39.7240 23.8142
";
*/

$DosyaIcerigi = file($DosyaAdi);
/*
$DosyaIcerigi[] = "2022.04.19 23:56:26 37.1352 29.1177";
$DosyaIcerigi[] = "2022.04.19 23:41:51 38.8798 43.5740";
$DosyaIcerigi[] = "2022.04.19 22:56:33 39.7240 23.8142";
*/

// echo "\n\n\nGELEN VERI\n\n\n";
// print_r($DosyaIcerigi);


/* ÖRNEK VERİ
2022.04.19 23:56:26 37.1352 29.1177
2022.04.19 23:41:51 38.8798 43.5740
2022.04.19 22:56:33 39.7240 23.8142
*/

require_once("connection.php");


foreach ($DosyaIcerigi as $key => $data) {
  //echo "SIRA $key: " . $DosyaIcerigi[$key];
  //echo "SIRA $key: " . $data;

  // 2022.04.19 22:56:33 39.7240 23.8142
  list($tarih, $saat, $enlem, $boylam) = explode(" ", $data);

  $tarih = str_replace(".", "-", $tarih);
  //Gelen verinin önünde ve ardındaki boşluk, enter, tab vb görünmeyen karaterleri temizle
  $tarih  = trim($tarih);
  $saat   = trim($saat);
  $enlem  = trim($enlem);
  $boylam = trim($boylam);
  /*
    echo "Tarih: $tarih\n";
    echo "Saat: $saat\n";
    echo "Enlem: $enlem\n";
    echo "Boylam: $boylam\n";
  */

/*
  ################ METOD 1 ################
  $SQL = "
    INSERT INTO depremler SET
    tarih='$tarih $saat',
    enlem='$enlem',
    boylam='$boylam'
  ";
  echo $SQL;

  $SORGU = $DB->prepare($SQL);
  $SORGU->execute();
*/

  ################ METOD 2 ################
  $SORGU  = $DB->prepare("INSERT INTO depremler SET
    tarih = :tarih,
    enlem = :enlem,
    boylam= :boylam");

  $tarihsaat = "$tarih $saat";

  $SORGU->bindParam(":tarih",  $tarihsaat);
  $SORGU->bindParam(":enlem",  $enlem);
  $SORGU->bindParam(":boylam", $boylam);

  $SORGU->execute();

} //foreach
