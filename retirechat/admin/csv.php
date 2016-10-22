<?php
include 'include.php';
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/csv");
header('Content-Disposition: attachment; filename=retire.csv');

//$query = "SELECT *, format(timediff(user.completed, user.created)/60,2) as minutes, abs(user.goal - user.totalvalue) as diff FROM user JOIN label USING(usercode) order by created desc";
include "query.php";

$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

$i = 0;
$rowCount = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result)) {

  if ($i == 0) {
    echo "\"".$i."\",";
    foreach ($row as $key=>$val) {
      if (!is_numeric($key)) {
        echo "\"".$key."\",";
      }
    }
    echo "\n";
    $i++;
  } 
  $num = $rowCount - $i;
  echo "\"".$num."\",";
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      echo "\"".$val."\",";
    }
  }
  echo "\n";
  $i++;
}
?>
