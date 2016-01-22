<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="15; URL=tiny.php">

<title>Centerstage</title>
<link rel="stylesheet" type="text/css" href="cstage.css">

</head>

<body bgcolor="#000000">
 <?php
$name2="";
$key2="";
$bpm2="";
$name3="";
$key3="";
$bpm3="";


$conn = new SQLite3("../db/Centerstage.sqlite3");
$sql_pointer="SELECT * FROM pointer";
$result_pointer = $conn->query($sql_pointer);
$row_pointer = $result_pointer -> fetchArray();
$pointer=$row_pointer["pointer"];
$sql_running1="SELECT * FROM running_show WHERE idrunning_show=" . $pointer;
$result_running1 = $conn->query($sql_running1);
$row_running1 = $result_running1 -> fetchArray();
$song1=$row_running1["song"];
$sql_songinfo1="SELECT * FROM song WHERE idsong=". $song1;
$result_songinfo1=$conn->query($sql_songinfo1);
$row_songinfo1 = $result_songinfo1 -> fetchArray();
$bpm1=$row_songinfo1["tempo"];
$key1=$row_songinfo1["pitch"];
$name1=$row_songinfo1["name"];


jump1:
    $pointer = $pointer + 1;
    $sql_running2="SELECT * FROM running_show WHERE idrunning_show=" . $pointer;
    $result_running2 = $conn->query($sql_running2);
    $row_running2 = $result_running2 -> fetchArray();
    $song2=$row_running2["song"];
    if ($song1 == $song2)
    {
     goto jump1;
    } 

    $sql_songinfo2="SELECT * FROM song WHERE idsong=". $song2;
    $result_songinfo2=$conn->query($sql_songinfo2);
    $row_songinfo2 = $result_songinfo2 -> fetchArray();
    $bpm2=$row_songinfo2["tempo"];
    $key2=$row_songinfo2["pitch"];
    $name2=$row_songinfo2["name"];
    if ($row_running2["eof"] == 1)
    {
     goto jump3;
    }




jump2:
    $pointer = $pointer + 1;
    $sql_running3="SELECT * FROM running_show WHERE idrunning_show=" . $pointer;
    $result_running3 = $conn->query($sql_running3);
    $row_running3 = $result_running3 -> fetchArray();
    $song3=$row_running3["song"];

    if ($song2 == $song3)
    {
     goto jump2;
    }

    $sql_songinfo3="SELECT * FROM song WHERE idsong=". $song3;
    $result_songinfo3=$conn->query($sql_songinfo3);
    $row_songinfo3 = $result_songinfo3 -> fetchArray();
    $bpm3=$row_songinfo3["tempo"];
    $key3=$row_songinfo3["pitch"];
    $name3=$row_songinfo3["name"];

jump3:
$conn->close();
?>
<table height="100%" width="100%">
<tr>
<td class="tiny_active">
<?php echo $name1; ?>
</td>
<td class="tiny_active">
<?php echo $bpm1; ?>
</td>
<td class="tiny_active">
<?php echo $key1; ?>
</td>
</tr>

<tr>
<td class="tiny_inactive">
<?php echo $name2; ?>
</td>
<td class="tiny_inactive">
<?php echo $bpm2; ?>
</td>
<td class="tiny_inactive">
<?php echo $key2; ?>
</td>
</tr>

<tr>
<td class="tiny_inactive">
<?php echo $name3; ?>
</td>
<td class="tiny_inactive">
<?php echo $bpm3; ?>
</td>
<td class="tiny_inactive">
<?php echo $key3; ?>
</td>
</tr>

</table>
<h1 align="center" class="inactive"><a href="tiny.php">RELOAD</a></h1>

</body></html>
