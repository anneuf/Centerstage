<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=song.php">
<title>Centerstage Delete Song</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Delete Song
</div>

<div id="edit_nav">
</div>

<div id="edit_main">

<?php
$song = $_GET["songid"];
$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql="DELETE FROM song WHERE idsong = " . $song;
$result = $conn->query($sql);

$conn -> close();

echo "<h3>Song " . $song . " has been deleted.</h3>";
?>

</div>

<div id="edit_footer">
</div>
</body></html>

