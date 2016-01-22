<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<?php
$idsong = $_POST["idsong"];
$page = $_POST["page"];
$content = $_POST["content"];
echo "<meta http-equiv=\"refresh\" content=\"1; URL=edit_page.php?song=" . $idsong . "&page=" . $page . "\">";
?>
<title>Centerstage Edit page</title>
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
include("text2html.php");


$db = new SQLite3("../db/Centerstage.sqlite3");

$sql1="DELETE FROM pages WHERE idsong=" . $idsong . " AND page=" . $page;
$results = $db->query($sql1);

$sql2="INSERT INTO pages (idsong,page,content) VALUES (" . $idsong . "," . $page . ",'" . t2h($content) . "')";
$results = $db->query($sql2);
echo "Page Updated/Added";
?>

</div>

<div id="edit_footer">
</div>

</body></html>
