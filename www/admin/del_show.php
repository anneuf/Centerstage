<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=show.php">
<title>Centerstage Delete Showfile</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Delete Showfile
</div>

<div id="edit_nav">
</div>

<div id="edit_main">

<?php
$show = $_GET["showid"];
$lim_l = $show * 1000;
$lim_h = ($show + 1) * 1000;
$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql1="DELETE FROM show WHERE idshow = " . $show;
$results1 = $conn->query($sql1);
$sql2="DELETE FROM song WHERE idsong>" . $lim_l . " AND idsong<" . $lim_h;
$results2 = $conn->query($sql2);
$sql3="DELETE FROM pages WHERE idsong>" . $lim_l . " AND idsong<" . $lim_h;
$results3 = $conn->query($sql3);


$conn -> close();

echo "<h3>Show " . $show . " has been deleted.</h3>";
?>
</div>

<div id="edit_footer">
</div>


</body></html>

