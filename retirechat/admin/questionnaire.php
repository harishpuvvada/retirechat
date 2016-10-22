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

include 'include.php';

header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<ul>
  <li><a href="questionnaire_questions.php">Download questions CSV file</a></li>
  <li><a href="questionnaire_answers.php">Download answers CSV file</a></li>
</ul>
<?php
$query = "SELECT * FROM question ORDER BY qid ASC";
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
  echo '</tr>';
  $j = -1;
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      if ($j == $row[7]) {
        echo "<td><b>$val</b></td>";
      } else {
        echo '<td>'.$val.'</td>';
      }
      $j++;
    }
  }
  echo '</tr>';
  $i++;
}
echo '</table>';

//$query = "SELECT * FROM (SELECT usercode, A.choice as choice1 , B.choice as choice2, C.choice as choice3, D.choice as choice4, E.choice as choice5, F.choice as choice6, G.choice as choice7, H.choice as choice8, I.choice as choice9, J.choice as choice10, K.choice as choice11, L.choice as choice12, M.choice as choice13, N.choice as choice14 , O.choice as choice15 FROM answer A JOIN answer B USING(usercode) JOIN answer C USING(usercode) JOIN answer D USING(usercode) JOIN answer E USING(usercode) JOIN answer F USING(usercode) JOIN answer G USING(usercode) JOIN answer H USING(usercode) JOIN answer I USING(usercode) JOIN answer J USING(usercode) JOIN answer K USING(usercode) JOIN answer L USING(usercode) JOIN answer M USING(usercode) JOIN answer N USING(usercode) JOIN answer O USING(usercode) WHERE A.qid = 1 AND B.qid = 2 AND C.qid = 3 AND D.qid = 4 AND E.qid = 5 AND F.qid = 6 AND G.qid = 7 AND H.qid = 8 AND I.qid = 9 AND J.qid = 10 AND K.qid = 11 AND L.qid = 12 AND M.qid = 13 AND N.qid = 14 AND O.qid = 15) Y JOIN (SELECT usercode, COUNT(*) as correctAnswers FROM answer JOIN question USING(qid) WHERE choice = correct GROUP BY usercode) Z USING(usercode)";

$query = "SELECT * FROM (SELECT usercode, groupid FROM user) as T JOIN (SELECT * FROM (SELECT usercode, A.choice as choice1 , B.choice as choice2, C.choice as choice3, D.choice as choice4, E.choice as choice5, F.choice as choice6, G.choice as choice7, H.choice as choice8, I.choice as choice9, J.choice as choice10, K.choice as choice11, L.choice as choice12, M.choice as choice13, N.choice as choice14 , O.choice as choice15 FROM answer A JOIN answer B USING(usercode) JOIN answer C USING(usercode) JOIN answer D USING(usercode) JOIN answer E USING(usercode) JOIN answer F USING(usercode) JOIN answer G USING(usercode) JOIN answer H USING(usercode) JOIN answer I USING(usercode) JOIN answer J USING(usercode) JOIN answer K USING(usercode) JOIN answer L USING(usercode) JOIN answer M USING(usercode) JOIN answer N USING(usercode) JOIN answer O USING(usercode) WHERE A.qid = 1 AND B.qid = 2 AND C.qid = 3 AND D.qid = 4 AND E.qid = 5 AND F.qid = 6 AND G.qid = 7 AND H.qid = 8 AND I.qid = 9 AND J.qid = 10 AND K.qid = 11 AND L.qid = 12 AND M.qid = 13 AND N.qid = 14 AND O.qid = 15) Y JOIN (SELECT usercode, COUNT(*) as correctAnswers FROM answer JOIN question USING(qid) WHERE choice = correct GROUP BY usercode) Z USING(usercode)) as U USING(usercode)";


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
