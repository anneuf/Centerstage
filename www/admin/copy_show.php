<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=show.php">
<title>Centerstage Copy Showfile</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Copy Showfile
</div>

<div id="edit_nav">
</div>

<div id="edit_main">

<?php
$show = $_GET["showid"];
$lim_l = $show * 1000;
$lim_h = ($show + 1) * 1000;
$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql1 = "SELECT idshow FROM show ORDER BY idshow DESC";
$results1 = $conn->query($sql1);
$row1 = $results1->fetchArray();
$newshow = $row1["idshow"] + 1;

$sql2 = "SELECT * FROM show WHERE idshow=" . $show;
$results2 = $conn->query($sql2);
$row2 = $results2->fetchArray();

$sql3 = "INSERT INTO show (idshow,label,sets,finish) VALUES (" . $newshow . ",'" . $row2["label"] . "'," . $row2["sets"] . ",'" . $row2["finish"] . "')";
$results3 = $conn->query($sql3);

$sql4 = "SELECT * FROM sets WHERE idshow=" . $show;
$results4 = $conn->query($sql4);

while ($row4=$results4->fetchArray()) {

  $sql5="INSERT INTO sets (idshow,idset,position,song) VALUES(" . $newshow . "," . $row4["idset"] . "," . $row4["position"] . "," . $row4["song"] . ")";
  $results5=$conn->query($sql5);

}

$sql6 = "SELECT * FROM song WHERE idsong>" . $lim_l . " AND idsong<" . $lim_h;
$results6 = $conn->query($sql6);

while ($row6=$results6->fetchArray()) {

  $newsong=$row6["idsong"]-$lim_l+(1000 * $newshow);
  $sql7="INSERT INTO song (idsong,name,artist,lyrics_pages,duration,pitch,tempo) VALUES(" . $newsong . ",'" . $row6["name"] . "','',1,'00:04:00','E',0)";
  $results7=$conn->query($sql7);

  $sql8="SELECT content FROM pages WHERE idsong=" . $row6["idsong"];
  $results8 = $conn->query($sql8);
  $row8 = $results8->fetchArray();

  $sql9="INSERT INTO pages (idsong,page,content) VALUES(" . $newsong . ",1,'" . $row8["content"] . "')";
  $results9 = $conn->query($sql9);


 
}


$conn -> close();

echo "<h3>Show " . $show . " has been copied to " . $newshow . ".</h3>";
?>
</div>

<div id="edit_footer">
</div>


</body></html>

