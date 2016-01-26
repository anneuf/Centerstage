<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Edit Set</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">
<div id="edit_header">
Centerstage Edit Set
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Start</a>
</div>

<div id="edit_main">
<?php
$idset = $_GET["setid"];
$idshow = $_GET["showid"];
$lim_l = $idshow*1000;
$lim_h = ($idshow+1)*1000;
$maxpos = 0;
$db = new SQLite3("../db/Centerstage.sqlite3");

$sql1 = "SELECT position,song FROM sets WHERE idset=" . $idset . " AND idshow=" . $idshow . " ORDER BY position";
$results1 = $db->query($sql1);

echo "<form action=\"edit_set_do.php\" method=\"post\">";
echo "<table id=\"edit_table\" width=\"800\">";
echo "<colgroup>";
echo "<col width=\"100\">";
echo "<col width=\"600\">";
echo "<col width=\"100\">";
echo "</colgroup>";
echo "<tr><th>Position</th><th>Song</th><th>Delete</th></tr>";

while ($row1=$results1->fetchArray())
  {
    $sql2 = "SELECT name FROM song WHERE idsong=" . $row1["song"];
    $results2 = $db->query($sql2);
    $row2=$results2->fetchArray();
    $sql3 = "SELECT idsong,name from song WHERE ((idsong < 1000) OR (idsong > " . $lim_l . " AND idsong < " . $lim_h . " )) ORDER BY name";
    $results3 = $db->query($sql3);

    echo "<tr>";

    echo "<td>" . $row1["position"] . "</td>";

    echo "<td>";
    echo "<select name=\"song";
    echo $row1["position"];
    echo "\">";

    while ($row3=$results3->fetchArray())

    {

      echo "<option ";
      if ($row3["idsong"] == $row1["song"]) echo "selected ";
      echo "value=\"";
      echo $row3["idsong"];
      echo "\">";
      echo $row3["name"];
      echo "</option>";

    }

    echo "</select>";
    echo "</td>";

    echo "<td>";
    echo "<input type=\"checkbox\" name=\"delete";
    echo $row1["position"];
    echo "\" value=\"1\">";
    echo "</td>";

    echo "</tr>";
    $maxpos = $row1["position"];
  }

echo "</table>";
echo "<input type=\"hidden\" id=\"maxpos\" name=\"maxpos\" value=\"" . $maxpos . "\">";
echo "<input type=\"hidden\" id=\"showid\" name=\"showid\" value=\"" . $idshow . "\">";
echo "<input type=\"hidden\" id=\"setid\" name=\"setid\" value=\"" . $idset . "\">";
echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"edit\">";
echo "<input type=\"submit\" value=\"Submit\">";
?>
</form>
</div>

<div id="edit_footer">
<form action="edit_set_do.php" method="post">
<table id="footer_table">
<colgroup>
<col width="500">
<col width="100">
</colgroup>
<tr id="footer_table">
<td id="footer_table">
<?php
    $sql4 = "SELECT idsong,name from song WHERE ((idsong < 1000) OR (idsong > " . $lim_l . " AND idsong < " . $lim_h . " )) ORDER BY name";
    $results4 = $db->query($sql4);

    echo "<select name=\"song\">";

    while ($row4=$results4->fetchArray())

    {

      echo "<option ";
      echo "value=\"";
      echo $row4["idsong"];
      echo "\">";
      echo $row4["name"];
      echo "</option>";

    }

    echo "</select>";
?>
</td>
<td id="footer_table">
<?php
echo "<input type=\"hidden\" id=\"maxpos\" name=\"maxpos\" value=\"" . $maxpos . "\">";
echo "<input type=\"hidden\" id=\"showid\" name=\"showid\" value=\"" . $idshow . "\">";
echo "<input type=\"hidden\" id=\"setid\" name=\"setid\" value=\"" . $idset . "\">";
echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"new\">";
echo "<input type=\"submit\" value=\"Add Song\">";
?>
</td>
</tr>
</table>
</div>
</body></html>
