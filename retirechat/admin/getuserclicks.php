<style>
table {
  border-collapse: collapse;
}
td {
  border: 1px solid #ccc;
  white-space: nowrap;
}
</style>
<?php
$usercode = $_GET['usercode'];

include 'include.php';

header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

echo "<ul>
        <li><a href='panel.php'>Main</a></li>
        <li><a href='getuser.php?usercode=$usercode'>User activity</a></li>
      </ul>";


$query = "SELECT symbol, name FROM fund ORDER BY fid ASC";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

echo '<table>';
$i = 0;
while($row = mysqli_fetch_array($result)) {
  
  if ($i == 0) {
    echo '<td>fund#</td>';
    foreach ($row as $key=>$val) {
      if (!is_numeric($key)) {
        echo '<td>'.$key.'</td>';
      }
    }
  }
  echo '</tr>';
  echo '<td>', $i+1, '</td>';
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      echo '<td>'.$val.'</td>';
    }
  }
  echo '</tr>';
  $i++;
}
echo '</table>';

$query = "SELECT * FROM compare WHERE usercode = '$usercode' ORDER BY time ASC";
$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

echo '<br><br>';
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
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      echo '<td>'.$val.'</td>';
    }
  }
  echo '</tr>';
  $i++;
}
echo '</table>';
?>
