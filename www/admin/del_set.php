<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<?php
echo "<meta http-equiv=\"refresh\" content=\"1; URL=edit_show.php?showid=" . $_GET["showid"] . "&newshow=0\">";
?>
<title>Centerstage Delete Set</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Delete Set
</div>

<div id="edit_nav">
</div>

<div id="edit_main">

<?php
$conn = new SQLite3("../db/Centerstage.sqlite3");

$sql1="DELETE FROM sets WHERE idshow = " . $_GET["showid"] . " AND idset=" . $_GET["setid"];
$results1 = $conn->query($sql1);

$conn -> close();

echo "<h3>Set " . $_GET["setid"] . " has been deleted.</h3>";
?>
</div>

<div id="edit_footer">
</div>


</body></html>

