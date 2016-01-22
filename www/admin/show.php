<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Edit Shows</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Edit Shows
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Back</a>
</div>

<div id="edit_main">

<table id="edit_table" width="900"> 
<colgroup>
<col width="100">
<col width="450">
<col width="150">
<col width="150">
</colgroup>
<tr>
<th>Number</th>
<th>Name of Show</th>
<th>Delete</th>
<th>Copy</th>
</tr>

<?php 

$maxid = 0;

$db = new SQLite3("../db/Centerstage.sqlite3");

$results = $db->query("SELECT idshow, label FROM show ORDER BY idshow");

    while ($row = $results->fetchArray())
      {
        echo "<tr><td><a href=\"edit_show.php?showid=" . $row["idshow"] . "&newshow=0\">" . $row["idshow"] . "</a></td><td>" . $row["label"] . "</td><td><a href=\"del_show.php?showid=" . $row["idshow"] . "\">Delete</a></td><td><a href=\"copy_show.php?showid=" . $row["idshow"] . "\">Copy</a></td></tr>";
        $maxid = max($maxid, $row["idshow"]);
      }

$maxid = $maxid + 1;

echo "</table>";
echo "</div>";
echo "<div id=\"edit_footer\">";
echo "<table id=\"footer_table\">";
echo "<tr id=\"footer_table\">";
echo "<td id=\"footer_table\">";
echo "<a href=\"edit_show.php?showid=" . $maxid . "&newshow=1\">New Show</a>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";
?>
</body></html>
