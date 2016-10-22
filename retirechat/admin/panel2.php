<style>
table {
  border-collapse: collapse;
}
td {
  border: 1px solid #ccc;
  white-space: nowrap;
  overflow: hidden;
  max-width: 320px;
  text-overflow: ellipsis;
}
</style>
<?php

include 'include.php';
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<ul>
  <li><a href="csv.php">Download CSV file</a></li>
  <li><a href="table.php">View CSV as HTML table</a></li>
  <li><a href="questionnaire.php">Questionnaire answers</a></li>
  <li><a href="fundavg_csv.php">Download average fund percentages CSV file</a></li>
  <!--<li><a href="bonus.php">Bonus workers not already bonused</a></li>-->
  <!--<li><a href="mtwid.php">Fix MTurk Worker IDs</a></li>-->
</ul>
<?php
//$query = "SELECT *, format(timediff(user.completed, user.created)/60,2) as minutes, abs(user.goal - user.totalvalue) as diff FROM user JOIN label USING(usercode) order by created desc";
$query = "
SELECT T.*, compare_clicks, fundname_clicks
FROM (
SELECT *, format(timediff(user.completed, user.created)/60,2) as minutes, abs(user.goal - user.totalvalue) as diff 
FROM user JOIN label USING(usercode) 
order by created desc) as T
LEFT JOIN
(SELECT usercode, COUNT(*) as compare_clicks
FROM compare
WHERE button = 'y'
GROUP BY usercode) as U ON T.usercode = U.usercode
LEFT JOIN
(SELECT usercode, COUNT(*) as fundname_clicks
FROM compare
WHERE button = 'n'
GROUP BY usercode) as V ON T.usercode = V.usercode";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

echo '<table>';
$i = 0;
while($row = mysqli_fetch_array($result)) {
  if ($i == 0) {
    foreach ($row as $key=>$val) {
      if (!is_numeric($key)) {
        echo '<td>'.$key.'</td>';
      }
    }
  }
  echo '<tr>';
  $usercode = "";
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      if ($key == 0) {
        echo '<td><a href="getuser.php?usercode='.$val.'">'.$val.'</a></td>';
        $usercode = $val;
      } else if ($key == 38 || $key == 39) {
        echo '<td><a href="getuserclicks.php?usercode='.$usercode.'">'.$val.'</a></td>';
      } else {
        echo '<td>'.$val.'</td>';
      }
    }
  }
  echo '</tr>';
  $i++;
}
echo '</table>';
?>
