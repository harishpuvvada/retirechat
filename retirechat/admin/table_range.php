<?php
include	'csv_range_query.php';
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: text/html");


$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire5") or die(mysql_error());
$query = $mainQuery;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$i = 0;
echo "<table>";
while($row = mysql_fetch_array($result)) {
  echo "<tr><td>".$i."</td>";
  if ($i == 0) {
    foreach ($row as $key=>$val) {
      if (!is_numeric($key)) {
        echo "<td>".$key."</td>";
      }
    }
  } else {
    foreach ($row as $key=>$val) {
      if (is_numeric($key)) {
        echo "<td>".$val."</td>";
      }
    }
  }
  echo "</tr>";
  $i++;
}
echo "</table>";
?>
<style>
body {
  margin: 0;
}
table {
  border-collapse: collapse;
}
td {
  border: 1px solid #ccc;
  white-space:nowrap;
  overflow: hidden;
  max-width: 240px;
  padding: 3px;
}
</style>
