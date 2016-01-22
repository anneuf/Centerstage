<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=song.php">
<title>Centerstage Edit Song</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Edit Song
</div>

<div id="edit_nav">
</div>

<div id="edit_main">



<?php
include "text2html.php";

$db = new SQLite3("../db/Centerstage.sqlite3");

if ($_POST["newsong"] == 0) {

$sql1="DELETE FROM song WHERE idsong=" . $_POST["idsong"];
$results = $db->query($sql1);

}
$sql3="SELECT DISTINCT page FROM pages WHERE idsong=" . $_POST["idsong"] . " ORDER by page DESC LIMIT 1";
$results3 = $db->query($sql3);
$row3 = $results3->fetchArray();


$sql2="INSERT INTO song(idsong,name,artist,lyrics_pages,duration,pitch,tempo) VALUES (" . $_POST["idsong"] . ",'" . text2html($_POST["name"]) . "','" . text2html($_POST["artist"]) . "'," . $row3["page"] . ",'" . $_POST["duration"] . "','" . $_POST["pitch"] . "'," . $_POST["tempo"] . ")";
$results = $db->query($sql2);
echo "Song Updated/Added";
?>

</div>

<div id="edit_footer">
</div>


</body></html>
