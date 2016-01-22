<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Edit Show</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<?php
$newshow = $_GET["newshow"];

$idshow = $_GET["showid"];
$label = ""; 

$db = new SQLite3("../db/Centerstage.sqlite3");



if ($newshow == 0) {
  $sql = "SELECT * FROM show WHERE idshow=" . $idshow;
  $results = $db->query($sql);
  $row = $results->fetchArray();
  $label = $row["label"];
}

?>

<div id="edit_header">
Centerstage Edit Show
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Start</a>
</div>

<div id="edit_main">

<form action="edit_show_do.php" method="post">
<table id="edit_table" width="800">
<colgroup>
<col width="150">
<col width="600">
</colgroup>
<?php
echo "<tr><td>Label</td>";
echo "<td><input type=\"text\" id=\"label\" name=\"label\" size=\"45\" maxlength=\"45\" value=\"" . $label . "\"></td></tr>";
echo "</table>";
echo "<input type=\"hidden\" id=\"idshow\" name=\"idshow\" value=\"" . $idshow . "\">";
echo "<input type=\"hidden\" id=\"newshow\" name=\"newshow\" value=\"" . $newshow . "\">";
echo "<input type=\"submit\" value=\"Submit\">";
?>
</form>
</div>

<div id="edit_footer">
<table id="footer_table">
<colgroup>
<col width="150">
<col width="200">
<col width="150">
</colgroup>
<tr id="footer_table">
<td id="footer_table">
<?php

$sql2 = "SELECT DISTINCT idset FROM sets WHERE idshow=" . $idshow . " ORDER BY idset";
$results2 = $db->query($sql2);
$newset=1;
while ($row2 = $results2->fetchArray())
  {

    echo "<a href=\"edit_set.php?showid=" . $idshow . "&setid=" . $row2["idset"] . "\">Edit Set " . $row2["idset"] . "</a><br>";
    $newset = $row2["idset"] + 1;
  }

echo "<a href=\"edit_set.php?showid=" . $idshow . "&setid=" . $newset . "\">Add Set</a> ";
?>
</td>
<td id="footer_table">
</td>
<td id="footer_table">
<?php
$lim_l = 1000 * $idshow;
$lim_h = 1000 * ($idshow +1 );
$sql3 = "SELECT idsong,name FROM song WHERE idsong>" . $lim_l . " AND idsong<" . $lim_h . " ORDER BY idsong";
$results3 = $db->query($sql3);
$newannounce=(1000*$idshow)+1;
while ($row3 = $results3->fetchArray())
  {

    echo "<a href=\"edit_page.php?song=" . $row3["idsong"] . "&page=1\">Edit " . $row3["name"] . "</a><br>"; 
    $newannounce = $row3["idsong"] + 1;
  }

echo "<a href=\"edit_page.php?song=" . $newannounce . "&page=1\">Add Announcement</a> ";
?>
</td>
</tr>
</table>

</div>
</body></html>
