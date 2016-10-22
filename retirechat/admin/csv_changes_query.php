<?php
include 'changes_query.php';
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/csv");
header('Content-Disposition: attachment; filename=retire.csv');

$conn = mysql_connect("localhost", "root", "BAgowan13sql") or die(mysql_error());
mysql_select_db("retire5") or die(mysql_error());
#$query = "SELECT *, (user.completed - user.created), abs(user.goal - user.totalvalue) FROM user";
$query = $mainQuery;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$i = 0;
while($row = mysql_fetch_array($result)) {
  echo "\"".$i."\",";
  if ($i == 0) {
    foreach ($row as $key=>$val) {
      if (!is_numeric($key)) {
        echo "\"".$key."\",";
      }
    }
  } else {
    foreach ($row as $key=>$val) {
      if (is_numeric($key)) {
        echo "\"".$val."\",";
      }
    }
  }
  echo "\n";
  $i++;
}
?>
