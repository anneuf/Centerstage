<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<?php
echo "<meta http-equiv=\"refresh\" content=\"1; URL=edit_set.php?showid=" . $_POST["showid"] . "&setid=" . $_POST["setid"] .  "\">";
?>
<title>Centerstage Edit Set</title>
<link href="edit.css" rel="stylesheet" type="text/css">
</head>

<body class="body_noshow">

<div id="edit_header">
Centerstage Edit Set
</div>

<div id="edit_nav">
</div>

<div id="edit_main">


<?php

$db = new SQLite3("../db/Centerstage.sqlite3");


switch ($_POST["action"]) {

  case "edit":
    $sql1 = "DELETE FROM sets WHERE idshow=" . $_POST["showid"] . " AND idset=" . $_POST["setid"];
    $results1 = $db->query($sql1);
    $pos = 1;
    for ($i = 1; $i <= $_POST["maxpos"]; $i++)
    {

      $song_pos = "song" . $i;
      $delete_pos = "delete" . $i;
      if (!isset($_POST[$delete_pos])) {
        $sql = "INSERT INTO sets (idshow,idset,position,song) VALUES (" . $_POST["showid"] . "," . $_POST["setid"] . "," . $pos . "," . $_POST[$song_pos] . ")";
        $results = $db->query($sql);
        $pos = $pos + 1;
      }

    }
    break;

  case "new":
    $position = $_POST["maxpos"] + 1;
    $sql = "INSERT INTO sets (idshow,idset,position,song) VALUES (" . $_POST["showid"] . "," . $_POST["setid"] . "," . $position . "," . $_POST["song"] . ")";
    $results = $db->query($sql);
    break;

}

?>

</div>

<div id="edit_footer">
</div>

</body></html>

