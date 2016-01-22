<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=../index.html">
<title>Centerstage Create Showfile</title>
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Delete Song
</div>

<div id="edit_nav">
</div>

<div id="edit_main">

<?php 
$id = 1;
$show = $_GET["doshow"];
$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql="DROP TABLE IF EXISTS running_show";
$result = $conn->query($sql); 

$sql="CREATE TABLE running_show ( idrunning_show integer NOT NULL, idshow integer DEFAULT NULL, idsets integer DEFAULT NULL, position integer DEFAULT NULL, song integer DEFAULT NULL, page integer DEFAULT NULL, pages integer DEFAULT NULL, bof integer DEFAULT NULL, eof integer DEFAULT NULL)";
$result = $conn->query($sql); 

$sql_show = "SELECT * FROM show WHERE idshow=" . $show;
$result_show = $conn->query($sql_show);
$row_show = $result_show -> fetchArray();
$sets = $row_show["sets"];
$showname = $row_show["label"];

for($i =1; $i <= $sets; $i++)
{
 $sql_set = "SELECT * FROM sets WHERE (idshow=" . $show . " AND idset=" . $i . ") ORDER BY position";
 $result_set = $conn->query($sql_set);
 while ($row_set = $result_set -> fetchArray() )
  {
   $position = $row_set["position"];
   $song = $row_set["song"];
   $sql_song = "SELECT * FROM song WHERE idsong=" . $song;
   $result_song = $conn->query($sql_song);
   $row_song = $result_song -> fetchArray();
   $pages = $row_song["lyrics_pages"];
   for($j =1; $j <= $pages; $j++)
    {
     $sql4="INSERT INTO running_show (idrunning_show, idshow, idsets, position, song, page, pages) VALUES (" . $id . ", " . $show . ", " . $i . ", " . $position . ", " . $song . ", " . $j . ", " . $pages . ")";
     $result4=$conn->query($sql4);
     $id = $id + 1;
    }
  }
}

$id=$id-1;
$sql="UPDATE running_show SET bof=1 WHERE idrunning_show=1";
$result = $conn->query($sql); 
$sql = "UPDATE running_show SET eof=1 WHERE idrunning_show=" . $id;
$result = $conn->query($sql); 
$conn -> close();

$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql="DROP TABLE IF EXISTS pointer";
$result = $conn->query($sql); 
$sql="CREATE TABLE pointer (pointer integer NOT NULL DEFAULT '1')";
$result = $conn->query($sql); 
$sql="INSERT INTO pointer (pointer) VALUES (1)";
$result = $conn->query($sql); 







$conn -> close();

echo "<h3>Show " . $showname . " wurde angelegt.</h3>";
?>

</div>

<div id="edit_footer">
</div>


</body></html>
