<?php
$query = "
SELECT *
FROM
(SELECT A.*, B.rebalance
FROM 
(SELECT T.*, compare_clicks, fundname_clicks                                                                                         
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
GROUP BY usercode) as V ON T.usercode = V.usercode) AS A
LEFT JOIN
(SELECT usercode, count(changemix) as rebalance FROM activity 
WHERE changemix = 'y'
GROUP BY usercode) AS B
ON A.usercode = B.usercode) as A
LEFT JOIN
(SELECT * FROM (SELECT usercode FROM user) as T JOIN (SELECT * FROM (SELECT usercode, A.choice     as choice1 , B.choice as choice2, C.choice as choice3, D.choice as choice4, E.choice as choice5, F.choice as choice6, G.choice as choice7, H.choice as choice8, I.choice as choice9, J.choice as choice10, K.choice as choice11    , L.choice as choice12, M.choice as choice13, N.choice as choice14 , O.choice as choice15 FROM answer A JOIN answer B USING(usercode) JOIN answer C USING(usercode) JOIN answer D USING(usercode) JOIN answer E USING(usercode)     JOIN answer F USING(usercode) JOIN answer G USING(usercode) JOIN answer H USING(usercode) JOIN answer I USING(usercode) JOIN answer J USING(usercode) JOIN answer K USING(usercode) JOIN answer L USING(usercode) JOIN answer M     USING(usercode) JOIN answer N USING(usercode) JOIN answer O USING(usercode) WHERE A.qid = 1 AND B.qid = 2 AND C.qid = 3 AND D.qid = 4 AND E.qid = 5 AND F.qid = 6 AND G.qid = 7 AND H.qid = 8 AND I.qid = 9 AND J.qid = 10 AND K.qid = 11 AND L.qid = 12 AND M.qid = 13 AND N.qid = 14 AND O.qid = 15) Y JOIN (SELECT usercode, COUNT(*) as correctAnswers FROM answer JOIN question USING(qid) WHERE choice = correct GROUP BY usercode) Z USING(usercode)) as     U USING(usercode)) as B USING (usercode)
";
?>
