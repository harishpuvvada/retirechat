<?php

$mainQuery = "
SELECT *, count1+count2+count3+count4+count5+count6+count7+count8+count9+count10 as totalchanges FROM

(select groupid, activity.usercode, completed, user.totalvalue, format((max(fund1pct) - min(fund1pct)),2) as fund1range, format((max(fund2pct) - min(fund2pct)),2) as fund2range, format((max(fund3pct) - min(fund3pct)),2) as fund3range, format((max(fund4pct) - min(fund4pct)),2) as fund4range, format((max(fund5pct) - min(fund5pct)),2) as fund5range, format((max(fund6pct) - min(fund6pct)),2) as fund6range, format((max(fund7pct) - min(fund7pct)),2) as fund7range, format((max(fund8pct) - min(fund8pct)),2) as fund8range, format((max(fund9pct) - min(fund9pct)),2) as fund9range, format((max(fund10pct) - min(fund10pct)),2) as fund10range, format(avg(fund1pct),2) as fund1avg, format(avg(fund2pct),2) as fund2avg, format(avg(fund3pct),2) as fund3avg, format(avg(fund4pct),2) as fund4avg, format(avg(fund5pct),2) as fund5avg, format(avg(fund6pct),2) as fund6avg, format(avg(fund7pct),2) as fund7avg, format(avg(fund8pct),2) as fund8avg, format(avg(fund9pct),2) as fund9avg, format(avg(fund10pct),2) as fund10avg from activity, user WHERE activity.usercode = user.usercode AND completed > 0 group by activity.usercode) AS ranges

LEFT JOIN

(select usercode, count(*)-1 as count1 from (select user.groupid, activity.usercode, activity.fund1pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund1pct) < 8 group by activity.usercode, activity.fund1pct) as fund1 group by usercode) as t1 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count2 from (select user.groupid, activity.usercode, activity.fund2pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund2pct) < 8 group by activity.usercode, activity.fund2pct) as fund2 group by usercode) as t2 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count3 from (select user.groupid, activity.usercode, activity.fund3pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund3pct) < 8 group by activity.usercode, activity.fund3pct) as fund3 group by usercode) as t3 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count4 from (select user.groupid, activity.usercode, activity.fund4pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund4pct) < 8 group by activity.usercode, activity.fund4pct) as fund4 group by usercode) as t4 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count5 from (select user.groupid, activity.usercode, activity.fund5pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund5pct) < 8 group by activity.usercode, activity.fund5pct) as fund5 group by usercode) as t5 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count6 from (select user.groupid, activity.usercode, activity.fund6pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund6pct) < 8 group by activity.usercode, activity.fund6pct) as fund6 group by usercode) as t6 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count7 from (select user.groupid, activity.usercode, activity.fund7pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund7pct) < 8 group by activity.usercode, activity.fund7pct) as fund7 group by usercode) as t7 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count8 from (select user.groupid, activity.usercode, activity.fund8pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund8pct) < 8 group by activity.usercode, activity.fund8pct) as fund8 group by usercode) as t8 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count9 from (select user.groupid, activity.usercode, activity.fund9pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund9pct) < 8 group by activity.usercode, activity.fund9pct) as fund9 group by usercode) as t9 USING(usercode)

LEFT JOIN

(select usercode, count(*)-1 as count10 from (select user.groupid, activity.usercode, activity.fund10pct from activity, user where activity.usercode = user.usercode and user.completed != '' and length(activity.fund10pct) < 8 group by activity.usercode, activity.fund10pct) as fund10 group by usercode) as t10 USING(usercode)
";

?>