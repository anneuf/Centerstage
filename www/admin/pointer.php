<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Navigate Show</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Navigate Show
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Back</a>
</div>


<div id="edit_main">
<table id="edit_table" width="1200">
<colgroup>
<col width="100">
<col width="450">
<col width="100">
</colgroup>
<tr>
<th>Position</th>
<th>Song</th>
<th>Page</th>
</tr>

<?php 

$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql1="DROP TABLE IF EXISTS pointer";
$results1 = $conn->query($sql1); 
$sql2="CREATE TABLE pointer (pointer integer NOT NULL DEFAULT '1')";
$results2 = $conn->query($sql2); 
$sql3="INSERT INTO pointer (pointer) VALUES (" . $_GET["pointer"] . ")";
$results3 = $conn->query($sql3);

$sql4="SELECT idrunning_show,song,page FROM running_show ORDER BY idrunning_show";
$results4 = $conn->query($sql4);

while ($row4=$results4->fetchArray()) {

  $sql5="SELECT name FROM song WHERE idsong=" . $row4["song"];
  $results5 = $conn->query($sql5);
  $row5=$results5->fetchArray();

  echo "<tr><td>";
  echo "<a href=\"pointer.php?pointer=" . $row4["idrunning_show"] . "\">" . $row4["idrunning_show"] . "</a>";
  echo "</td><td>";
  echo $row5["name"];
  echo "</td><td>";
  echo $row4["page"];
  echo "</td></tr>";


}

$conn -> close();

?>
</table>
</div>";
<div id=\"edit_footer\">
</div>

</body></html>
