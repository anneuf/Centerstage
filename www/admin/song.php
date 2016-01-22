<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Edit Song</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Edit Song
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Back</a>
</div>


<div id="edit_main">
<table id="edit_table" width="1200">
<colgroup>
<col width="350">
<col width="350">
<col width="300">
<col width="100">
</colgroup>
<tr>
<th>Song</th>
<th>Artist</th>
<th>Sets</th>
<th>Delete</th>
</tr>

<?php 

$maxid = 0;

$db1 = new SQLite3("../db/Centerstage.sqlite3");

$results1 = $db1->query("SELECT idsong, artist, name FROM song WHERE idsong<1000 ORDER BY name");

    while ($row1 = $results1->fetchArray())
      {
        echo "<tr><td><a href=\"edit_song.php?songid=" . $row1["idsong"] . "&newsong=0\">" . $row1["name"] . "</a></td><td>" . $row1["artist"] . "</td><td>";
	$db2 = new SQLite3("../db/Centerstage.sqlite3");
        $results2 = $db2->query("SELECT idset, idshow FROM sets WHERE song=$row1[idsong]");
	  while ($row2 = $results2->fetchArray())
		{
			echo $row2["idshow"] . "/" . $row2["idset"] . ",";
		} 

        echo "</td><td><a href=\"del_song.php?songid=" . $row1["idsong"] . "\">Delete</a></td></tr>";
        
        $maxid = max($maxid, $row1["idsong"]);
      }

$maxid = $maxid + 1;

echo "</table>";
echo "</div>";
echo "<div id=\"edit_footer\">";
echo "<table id=\"footer_table\">";
echo "<tr id=\"footer_table\">";
echo "<td id=\"footer_table\">";
echo "<a href=\"edit_song.php?songid=" . $maxid . "&newsong=1\">New Song</a>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";

$db1->close();
?>
</body></html>
