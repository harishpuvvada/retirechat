<?php
include 'include.php';
header("Expires: Mon, 26 Jul 12012 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/csv");
header('Content-Disposition: attachment; filename=questionnaire_answers.csv');

$query = "SELECT   * FROM   (SELECT      usercode,      groupid    FROM      user) as T JOIN   (      SELECT         *       FROM         (SELECT            usercode,            A.choice as choice1 ,            B.choice as choice2,            C.choice as choice3,            D.choice as choice4,            E.choice as choice5,            F.choice as choice6,            G.choice as choice7,            H.choice as choice8,            I.choice as choice9,            J.choice as choice10,            K.choice as choice11,            L.choice as choice12,            M.choice as choice13,            N.choice as choice14 ,            O.choice as choice15 ,            QA.correct = A.choice as right1,            QB.correct = B.choice as right2,            QC.correct = C.choice as right3,            QD.correct = D.choice as right4,            QE.correct = E.choice as right5,            QF.correct = F.choice as right6,            QG.correct = G.choice as right7,            QH.correct = H.choice as right8,            QI.correct = I.choice as right9,            QJ.correct = J.choice as right10,            QK.correct = K.choice as right11,            QL.correct = L.choice as right12,            QM.correct = M.choice as right13,            QN.correct = N.choice as right14,            QO.correct = O.choice as right15         FROM            answer A          JOIN            answer B USING(usercode)          JOIN            answer C USING(usercode)          JOIN            answer D USING(usercode)          JOIN            answer E USING(usercode)          JOIN            answer F USING(usercode)          JOIN            answer G USING(usercode)          JOIN            answer H USING(usercode)          JOIN            answer I USING(usercode)          JOIN            answer J USING(usercode)          JOIN            answer K USING(usercode)          JOIN            answer L USING(usercode)          JOIN            answer M USING(usercode)          JOIN            answer N USING(usercode)          JOIN            answer O USING(usercode)         JOIN            question QA         JOIN            question QB         JOIN            question QC         JOIN            question QD         JOIN            question QE         JOIN            question QF         JOIN            question QG         JOIN            question QH         JOIN            question QI         JOIN            question QJ         JOIN            question QK         JOIN            question QL         JOIN            question QM         JOIN            question QN         JOIN            question QO         WHERE            A.qid = 1             AND B.qid = 2             AND C.qid = 3             AND D.qid = 4             AND E.qid = 5             AND F.qid = 6             AND G.qid = 7             AND H.qid = 8             AND I.qid = 9             AND J.qid = 10             AND K.qid = 11             AND L.qid = 12             AND M.qid = 13             AND N.qid = 14             AND O.qid = 15            AND QA.qid = 1            AND QB.qid = 2            AND QC.qid = 3            AND QD.qid = 4            AND QE.qid = 5            AND QF.qid = 6            AND QG.qid = 7            AND QH.qid = 8            AND QI.qid = 9            AND QJ.qid = 10            AND QK.qid = 11            AND QL.qid = 12            AND QM.qid = 13            AND QN.qid = 14            AND QO.qid = 15         ) Y       JOIN         (            SELECT               usercode,               COUNT(*) as correctAnswers             FROM               answer             JOIN               question USING(qid)             WHERE               choice = correct             GROUP BY               usercode         ) Z USING(usercode)      ) as U USING(usercode)";

$result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

$i = 0;
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
  echo "\"".$i."\",";
  foreach ($row as $key=>$val) {
    if (is_numeric($key)) {
      echo "\"".$val."\",";
    }
  }
  echo "\n";
  $i++;
}
?>
