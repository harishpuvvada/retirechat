<?php

include 'include.php';
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: text/html");

//$query = "SELECT *, format(timediff(user.completed, user.created)/60,2) as minutes, abs(user.goal - user.totalvalue) as diff FROM user JOIN label USING(usercode) order by created desc";
include 'query.php';

$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

$i = 0;
echo "<table>";
while($row = mysqli_fetch_array($result)) {
  if ($i == 0) {
    echo "<tr><td>".$i."</td>";
    foreach ($row as $key=>$val) {
      if (!is_numeric($key)) {
        echo "<td>".$key."</td>";
      }
    }
    echo "</tr>";
    $i++;
  } 
  echo "<tr><td>".$i."</td>";
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      echo "<td>".$val."</td>";
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
