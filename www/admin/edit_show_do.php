<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=show.php">
<title>Centerstage Edit Show</title>
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

include "text2html.php";

$db = new SQLite3("../db/Centerstage.sqlite3");

if ($_POST["newshow"] == 0) {

$sql1="DELETE FROM show WHERE idshow=" . $_POST["idshow"];
$results = $db->query($sql1);

}
$sql3="SELECT DISTINCT idset FROM sets ORDER BY idset DESC LIMIT 1";
$results3 = $db->query($sql3);
$row3=$results3->fetchArray();

$sql2="INSERT INTO show(idshow,label,sets) VALUES (" . $_POST["idshow"] . ",'" . text2html($_POST["label"]) . "'," . $row3["idset"] . ")";
$results = $db->query($sql2);
echo "Show Updated/Added";



?>
</div>

<div id="edit_footer">
</div>

</body></html>
