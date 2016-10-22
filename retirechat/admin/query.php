<?php
$query = "
SELECT 
a.usercode as usercode, mtwid, groupid, ipaddress, location, totalvalue,
diff, within10,reward, age, gender, experience, hasretire,novice,
created, completed, minutes, fee,
answer1, answer2, answer3,                                                                                     
answer4, answer5, answer6, answer7, answer8, comments
 FROM
(SELECT user.usercode as usercode, mtwid, groupid, ipaddress, location, totalvalue,                             
abs(goal - totalvalue) as diff,                                                                                
abs(goal - totalvalue) <= 150000 as within10,                                                                  
reward, age, gender, experience, hasretire,                                                                    
experience <= 2 as novice,                                                                                     
created, completed,                                                                                            
TIMESTAMPDIFF(MINUTE,created,completed) as minutes,                                                            
answer1, answer2, answer3,                                                                                     
answer4, answer5, answer6, answer7, answer8, comments                                                          
FROM questionnaire                                                                                             
LEFT JOIN user                                                                                                 
ON questionnaire.usercode=user.usercode) a
LEFT JOIN
(SELECT usercode, 
FORMAT(avg(fund3pct)+avg(fund4pct)+avg(fund9pct),3) as fee
FROM activity
GROUP BY usercode) b
ON a.usercode = b.usercode
"?>
