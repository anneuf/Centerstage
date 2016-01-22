<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=../index.html">
<title>Centerstage Cleanup</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Cleanup
</div>

<div id="edit_nav">
</div>

<div id="edit_main">

<?php
$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql1="SELECT idsong FROM song";
$results1 = $conn->query($sql1);

while ($row1=$results1->fetchArray()) {

  $idsong=$row1["idsong"];
  $page_count=0;
  $sql2="SELECT page FROM pages WHERE idsong=" . $idsong;
  $results2 = $conn->query($sql2);
  while ($row2=$results2->fetchArray()) {

    $page_count=$page_count+1;

  }

  $sql3="UPDATE song SET lyrics_pages=" . $page_count . " WHERE idsong=" . $idsong;
  $results3 = $conn->query($sql3);

}

$sql4="SELECT idshow FROM show";
$results4 = $conn->query($sql4);

while ($row4=$results4->fetchArray()) {

  $idshow=$row4["idshow"];
  $set_count=0;
  $sql5="SELECT DISTINCT idset FROM sets WHERE idshow=" . $idshow;
  $results5 = $conn->query($sql5);
  while ($row5=$results5->fetchArray()) {

    $set_count=$set_count+1;

  }

  $sql6="UPDATE show SET sets=" . $set_count . " WHERE idshow=" . $idshow;
  $results6 = $conn->query($sql6);

}

?>

</div>

<div id="edit_footer">
</div>
</body></html>
