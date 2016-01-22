<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="refresh" content="1; URL=cstage.php">

<title>Centerstage</title>
<link rel="stylesheet" type="text/css" href="cstage.css">

</head>

<body>
 <?php
$conn = new SQLite3("../db/Centerstage.sqlite3");
$sql_pointer="SELECT * FROM pointer";
$result_pointer = $conn->query($sql_pointer);
$row_pointer = $result_pointer -> fetchArray();
$sql_running="SELECT * FROM running_show WHERE idrunning_show=" . $row_pointer["pointer"];
$result_running = $conn->query($sql_running);
$row_running = $result_running -> fetchArray();
$sql_show="SELECT * FROM show WHERE idshow=" . $row_running["idshow"];
$result_show = $conn->query($sql_show);
$row_show = $result_show -> fetchArray();
$sql_page="SELECT * FROM pages WHERE idsong=" . $row_running["song"] . " AND page=" . $row_running["page"];
$result_page = $conn->query($sql_page);
$row_page = $result_page->fetchArray();
$sql_songinfo="SELECT * FROM song WHERE idsong=". $row_running["song"];
$result_songinfo=$conn->query($sql_songinfo);
$row_songinfo = $result_songinfo -> fetchArray();
$bpm=$row_songinfo["tempo"];
$key=$row_songinfo["pitch"];
$sql_sets="SELECT * FROM sets WHERE idshow=" . $row_running["idshow"] . " AND idset=" . $row_running["idsets"];
$result_sets = $conn->query($sql_sets);
$set_songs = 0; 
while ($row_songs = $result_sets->fetchArray()) {
   $set_songs = $set_songs + 1;
}
?>
<div id="main">
 <table height="1080">
   <td>
    <?php 
       echo $row_page["content"];
    ?>
   </td>
 </table>
</div>
<div id="set">
 <table height="80" width="420"> 
  <td>
    <?php 
     echo $row_show["label"] . "<br>Set " . $row_running["idsets"]; 
    ?>
  </td>
 </table>
</div>
<div id="setlist">
 <table height="800" width="420">
  <td>
    <?php
      if(($set_songs>20) and ($row_running["position"]<11))
       {
         $set_start=1;
         $set_end=20;
       }
      elseif(($set_songs>20) and (($row_running["position"]+10)<=$set_songs))
       {
         $set_start=$row_running["position"]-9;
         $set_end=$set_start+19;
       }
      elseif(($set_songs>20) and (($row_running["position"]+19)>$set_songs))
       {
         $set_start=$set_songs-19;
         $set_end=$set_songs;
       }
      else
        {
         $set_start=1;
         $set_end=$set_songs;
       }
      for($i=$set_start; $i<=$set_end; $i++)
       {
        $sql_setlist="SELECT song FROM sets WHERE idshow=" . $row_running["idshow"] . " AND idset=" . $row_running["idsets"] . " AND position=" . $i;
        $result_setlist = $conn->query($sql_setlist);
        $row_setlist = $result_setlist->fetchArray();
        $sql_pos="SELECT name FROM song WHERE idsong=" . $row_setlist["song"];
        $result_pos = $conn->query($sql_pos);
        $row_pos = $result_pos->fetchArray();
        $in="";
        if($i<>$row_running["position"]) { $in="in";  }

        echo "<div class=\"" . $in . "active\">" . $row_pos["name"] . "</div>";
     
      }
    ?>
  </td>
 </table>
</div>
<div id="time">
 <table height="100" width="420">
  <td>
    <?php echo(date("H:i:s")); ?>
  </td>
 </table>
</div>
<div id="page">
 <table height="100" width="100">
  <td>
   <?php echo $row_running["page"] . "/" . $row_running["pages"]; ?>
  </td>
 </table>
</div>
<div id="key">
 <table height="100" width="140">
  <td>
    <?php 
     echo $key; 
    ?>
  </td>
 </table>
</div>
</div>
<div id="bpm">
 <table height="100" width="180">
  <td>
    <?php 
     echo $bpm;
     $conn->close(); 
    ?>
  </td>
 </table>
</div>

</body></html>
