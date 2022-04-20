cd /var/www/html/deprem

wget -O deprem.txt http://www.koeri.boun.edu.tr/scripts/lst7.asp

iconv -f CP1250 -t UTF-8 < deprem.txt  >sonuc.txt

cat sonuc.txt|grep -E "2022.04.20" |cut -d " " -f1,2,4,7 >1.txt
# cat sonuc.txt|grep -E "2022.04.19 23|2022.04.19 22" |cut -d " " -f1,2,4,7 >1.txt

clear

curl -F deprem_data=@"1.txt" http://localhost/deprem/putdeprem.php

rm -f 1.txt deprem.txt sonuc.txt

