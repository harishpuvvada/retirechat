<?php

include 'include.php';

$usercode = $_SESSION["usercode"];
$year = $_SESSION["year"];
$month = $_SESSION["month"];
$fundpct = array();

$query = "SELECT fund1pct, fund2pct, fund3pct, fund4pct, fund5pct, fund6pct, fund7pct, fund8pct, fund9pct, fund10pct FROM activity ORDER BY modified DESC LIMIT 0,1";

if ($result = mysqli_query($conn, $query)) {
  while ($row = mysqli_fetch_row($result)) {
   /* $total++;
    array_push($name, $row[0]);
    array_push($thisYear, $row[1]);*/

var_dump($row);



}
}
else{

echo "something wrong";

}

echo $result;


?>






