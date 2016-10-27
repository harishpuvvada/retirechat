<?php

include 'include.php';

$usercode = $_SESSION["usercode"];
$year = $_SESSION["year"];
$month = $_SESSION["month"];

//$query = "SELECT name FROM fund";

$fundpct = array();

$query = mysqli_prepare($conn, "SELECT fund1pct, fund2pct, fund3pct, fund4pct, fund5pct, fund6pct, fund7pct, fund8pct, fund9pct, fund10pct, totalvalue FROM activity ORDER BY modified DESC LIMIT 0,1";


$name=array();
$thisYear = array();
$total = 0; // number of rows

if ($result = mysqli_query($connection, $query)) {
  while ($row = mysqli_fetch_row($result)) {
   /* $total++;
    array_push($name, $row[0]);
    array_push($thisYear, $row[1]);*/

var_dump($row);
echo "<h r/>";
echo $row;

}
}
else{

echo "something wrong";

}

echo $result;



?>






<!-- //$ result = [{
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
//}] -->