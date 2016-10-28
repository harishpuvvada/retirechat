<?php

include 'include.php';

$usercode = $_SESSION["usercode"];
$year = $_SESSION["year"];
$month = $_SESSION["month"];
$fundpct = array();

$query1 = "SELECT fund1pct, fund2pct, fund3pct, fund4pct, fund5pct, fund6pct, fund7pct, fund8pct, fund9pct, fund10pct FROM activity ORDER BY modified DESC LIMIT 0,1";

$query2 = "SELECT name FROM fund";





if ($result1 = mysqli_query($conn, $query1)) {
  while ($row = mysqli_fetch_assoc($result1)) {
   /* $total++;
    array_push($name, $row[0]);
    array_push($thisYear, $row[1]);*/

//var_dump($row);
echo $row["fund1pct"]."<br />";
echo $row["fund2pct"]."<br />";
echo $row["fund3pct"]."<br />";
echo $row["fund4pct"]."<br />";
echo $row["fund5pct"]."<br />";
echo $row["fund6pct"]."<br />";
echo $row["fund7pct"]."<br />";
echo $row["fund8pct"]."<br />";
echo $row["fund9pct"]."<br />";
echo $row["fund10pct"]."<br />";


}
}
else{

echo "something wrong in 1";

}

if ($result2 = mysqli_query($conn, $query2)) {
  while ($row2 = mysqli_fetch_assoc($result2)) {
  

//var_dump($row);
var_dump($row2);

}
}
else{

echo "something wrong in 2";

}



echo $result1;

echo $result2;




?>






