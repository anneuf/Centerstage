<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Create Showfile</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Create Showfile
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Back</a>
</div>

<div id="edit_main">
<table id="edit_table" width="700">
<colgroup>
<col width="100">
<col width="500">
</colgroup>
<tr>
<th>Number</th>
<th>Name of Show</th>
</tr>

<?php 

$db = new SQLite3("../db/Centerstage.sqlite3");

$results = $db->query("SELECT idshow, label FROM show");

    while ($row = $results->fetchArray())
      {
        echo "<tr><td><a href=\"create_do.php?doshow=" . $row["idshow"] . "\">" . $row["idshow"] . "</a></td><td>" . $row["label"] . "</td></tr>";
      }


?>

</table>
</div>

<div id="edit_footer">
</div>
</body></html>
