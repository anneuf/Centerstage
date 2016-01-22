<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<script src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
    selector: '#mytextarea',
    width : 768,
    height : 553,
    content_css : 'edit.css',
    body_id : 'main_edit',
    force_p_newlines : false,
    forced_root_block : false,
    menubar : false,
    toolbar : 'undo redo | styleselect',
    entities : '160,nbsp,162,cent,8364,euro,163,pound,39',
    font_formats: 'Arial=arial,helvetica',
    resize : false,
    style_formats: [
      {title: 'Tomo', inline : 'span', styles: { color: '#FFFFFF'}},
      {title: 'Patricia', inline : 'span', styles: { color: '#FFFF00'}},
      {title: 'Tomo+Pat', inline : 'span', styles: { color: '#88FF88'}},
      {title: 'Singer 4', inline : 'span', styles: { color: '#FF00FF'}},
      {title: 'Singer 5', inline : 'span', styles: { color: '#00FFFF'}},
      {title: 'Singer 6', inline : 'span', styles: { color: '#FF8888'}},
      {title: 'Singer 7', inline : 'span', styles: { color: '#8888FF'}},
      {title: 'Singer 8', inline : 'span', styles: { color: '#888888'}}
    ]
  });
</script>
<title>Centerstage Edit Page</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<?php
include "text2html.php";
$page = $_GET["page"];

$idsong = $_GET["song"];
$db = new SQLite3("../db/Centerstage.sqlite3");

$sql = "SELECT content FROM pages WHERE idsong=" . $idsong . " AND page=" . $page;
$results = $db->query($sql);
$content = "";
while ($row = $results->fetchArray())
  {
  $content = $row["content"];
  }

$sql2 = "SELECT name FROM song WHERE idsong=" . $idsong;
$results2 = $db->query($sql2);
$row2 = $results2->fetchArray();
$name = $row2["name"];

?>
<div id="edit_header">
Centerstage Edit Page
</div>

<div id="edit_nav">
<a href="show.php">Edit Shows</a><br>
<a href="song.php">Edit Songs</a><br>
<br>
<a href="../index.html">Start</a>
</div>

<div id="edit_main">
<table id="edit_table" width="800">
<colgroup>
<col width="350">
<col width="100">
</colgroup>
<?php
echo "<tr><th>Song</th><th>Page</th></tr>";
echo "<tr><td>";
echo $name;
echo "</td><td>";
echo $page;
echo "</td></tr>";

?>
</table>
<form action="edit_page_do.php" method="post">
<?php

echo "<p><textarea name=\"content\" id=\"mytextarea\">" . $content . "</textarea></p>";
echo "<input type=\"hidden\" id=\"idsong\" name=\"idsong\" value=\"" . $idsong . "\">";
echo "<input type=\"hidden\" id=\"page\" name=\"page\" value=\"" . $page . "\">";
echo "<input type=\"submit\" value=\"Submit\">";
?>
</form>
</div>
<div id="edit_footer">
</div>
</body></html>
