<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>Centerstage Edit Song</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<?php
$newsong = $_GET["newsong"];

$idsong = $_GET["songid"];
$name = "";
$artist = "";
$lyrics_pages = 1;
$duration = "00:04:00";
$pitch = "E";
$tempo = 120;

$db = new SQLite3("../db/Centerstage.sqlite3");



if ($newsong == 0) {
  $sql = "SELECT * FROM song WHERE idsong=" . $idsong;
  $results = $db->query($sql);
  $row = $results->fetchArray();
  $name = $row["name"];
  $artist = $row["artist"];
  $lyrics_pages = $row["lyrics_pages"];
  $duration = $row["duration"];
  $pitch = $row["pitch"];
  $tempo = $row["tempo"];

  }

?>

<div id="edit_header">
Centerstage Edit Song
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Start</a>
</div>

<div id="edit_main">

<form action="edit_song_do.php" method="post">
<table id="edit_table" width="800">
<colgroup>
<col width="150">
<col width="600">
</colgroup>
<?php
echo "<tr><td>Name</td>";
echo "<td><input type=\"text\" id=\"name\" name=\"name\" size=\"45\" maxlength=\"45\" value=\"" . $name . "\"></td></tr>";
echo "<tr><td>Artist</td>";
echo "<td><input type=\"text\" id=\"artist\" name=\"artist\" size=\"45\" maxlength=\"45\" value=\"" . $artist . "\"></td></tr>";
echo "<tr><td>Duration</td>";
echo "<td><input type=\"text\" id=\"duration\" name=\"duration\" value=\"" . $duration . "\"></td></tr>";
echo "<tr><td>Pitch</td>";
echo "<td><input type=\"text\" id=\"pitch\" name=\"pitch\" value=\"" . $pitch . "\"></td></tr>";
echo "<tr><td>Tempo</td>";
echo "<td><input type=\"text\" id=\"tempo\" name=\"tempo\" value=\"" . $tempo . "\"></td></tr>";
echo "</table>";
echo "<input type=\"hidden\" id=\"idsong\" name=\"idsong\" value=\"" . $idsong . "\">";
echo "<input type=\"hidden\" id=\"newsong\" name=\"newsong\" value=\"" . $newsong . "\">";
echo "<input type=\"submit\" value=\"Submit\">";
?>
</form>
</div>

<div id="edit_footer">
<table id="footer_table">
<tr id="footer_table">
<td id="footer_table">
<?php

$sql2 = "SELECT page FROM pages WHERE idsong=" . $idsong . " ORDER BY page";
$results2 = $db->query($sql2);
while ($row2 = $results2->fetchArray())
  {

    echo "<a href=\"edit_page.php?song=" .  $idsong . "&page=" . $row2["page"] . "\">Edit Page " . $row2["page"] . "</a> ";
    echo "<br>";
    $newpage = $row2["page"] + 1;
  }

echo "<a href=\"edit_page.php?song=" .  $idsong . "&page=" . $newpage . "\">Add Page</a> ";

?>
</td>
</tr>
</div>
</body></html>
