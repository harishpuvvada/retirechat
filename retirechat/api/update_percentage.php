<?php

include 'include.php';

$usercode = $_SESSION["usercode"];
$year = $_SESSION["year"];
$month = $_SESSION["month"];



$query = "SELECT name,thisYear FROM fund ORDER BY fid ASC";


$name=array();
$thisYear = array();
$total = 0; // number of rows

if ($result = mysqli_query($conn, $query)) {
  while ($row = mysqli_fetch_row($result)) {
    $total++;
    array_push($name, $row[0]);
    array_push($thisYear, $row[1]);

//$ result = [{
  //"name" : "invest grade bond fund a",
  //"portfolio" : 0,
  //"percentage" : ""
//},{
  //"name" : "invest grade bond fund a",
  //"portfolio" : 0,
  //"percentage" : ""
//},{
  //"name" : "invest grade bond fund a",
  //"portfolio" : 0,
  //"percentage" : ""
//}]
}
}

echo $result;



?>