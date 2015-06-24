<?php 

$date = date("Y-m-d H:i:s");
$date2 = strtotime("Y-m-d H:i:s" + 24*3600);
$nb = round(strtotime($date) - strtotime($date2));

echo "Il reste $nb";

 ?>