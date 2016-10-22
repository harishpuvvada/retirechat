<?php

$mainQuery = "
select groupid, usercode, created, completed, year, reward, goal, totalvalue, difference, age, experience, hasretire, gender, minutes, stockchange, bondchange, cashchange, totalchange, stockavg, bondavg, cashavg, stockrange, bondrange, cashrange, mtwid, stdev_stockpct, stdev_bondpct, stdev_cashpct, stdev_totalval, ipaddress, location, maxstockpctdelta, maxbondpctdelta, maxcashpctdelta, absdeltasum, absdeltastocksum, absdeltabondsum, absdeltacashsum, comments

 from (

(select usercode as uc2, format(max(stockpctdelta),2) as maxstockpctdelta, format(max(bondpctdelta),2) as maxbondpctdelta, format(max(cashpctdelta),2) as maxcashpctdelta, format(sum(abs(stockpctdelta)) + sum(abs(bondpctdelta)) + sum(abs(cashpctdelta)),2) as absdeltasum, format(sum(abs(stockpctdelta)),2) as absdeltastocksum, format(sum(abs(bondpctdelta)),2) as absdeltabondsum, format(sum(abs(cashpctdelta)),2) as absdeltacashsum from activity where year != 1981 group by usercode)

) as deltas inner join (

(select groupid, usercode, created, completed, year, reward, goal, totalvalue, difference, age, experience, hasretire, gender, minutes, stockchange, bondchange, cashchange, totalchange, stockavg, bondavg, cashavg, stockrange, bondrange, cashrange, mtwid,

format((abs(stockavg-(SELECT avg(stockpct) FROM activity))/(SELECT std(stockpct) FROM activity)),3) as stdev_stockpct,
format((abs(bondavg-(SELECT avg(bondpct) FROM activity))/(SELECT std(bondpct) FROM activity)),3) as stdev_bondpct,
format((abs(cashavg-(SELECT avg(cashpct) FROM activity))/(SELECT std(cashpct) FROM activity)),3) as stdev_cashpct,
stdev_totalval,

ipaddress, location, comments

from (select groupid, usercode, created, completed, year, reward, goal, totalvalue, difference, age, experience, hasretire, gender, minutes, stockchange, bondchange, cashchange, totalchange, stockavg, bondavg, cashavg, stockrange, bondrange, cashrange, mtwid,

format(abs(totalvalue-(SELECT avg(totalvalue) FROM user))/(SELECT std(totalvalue) FROM user),3) as stdev_totalval,

ipaddress, location, comments

 from (

(select usercode as usercodeavg, format((max(stockpct) - min(stockpct)),2) as stockrange, format((max(bondpct) - min(bondpct)),2) as bondrange, format((max(cashpct) - min(cashpct)),2) as cashrange, format(avg(stockpct),2) as stockavg, format(avg(bondpct),2) as bondavg, format(avg(cashpct),2) as cashavg from activity group by usercode)

) as assetavgs inner join (

(select userall.groupid, userall.usercode as usercode, ipaddress, location, created, completed, year, reward, goal, totalvalue, difference, age, experience, hasretire, gender, minutes, stockdiff as stockchange, bonddiff as bondchange, cashdiff as cashchange, totaldiff as totalchange, mtwid, comments from (

(select groupid, ucs as usercode, counts as stockdiff, countb as bonddiff, countc as cashdiff, (counts+countb+countc) as totaldiff from (
(select * from (select * from (
select * from (select usercode as ucs, count(*)-1 as counts from (select user.groupid, activity.usercode, activity.stockpct from activity, user where activity.usercode = user.usercode and user.completed != '' group by activity.usercode, activity.stockpct) as stk group by usercode
) as stock inner join (
select usercode as ucb, count(*)-1 as countb from (select user.groupid, activity.usercode, activity.bondpct from activity, user where activity.usercode = user.usercode and user.completed != '' group by activity.usercode, activity.bondpct) as stk group by usercode
) as bond on stock.ucs=bond.ucb) as stockbond) as sb)
) as sb2 inner join (
(select usercode as ucc, count(*)-1 as countc, groupid from (select user.groupid, activity.usercode, activity.cashpct from activity, user where activity.usercode = user.usercode and user.completed != '' group by activity.usercode, activity.cashpct) as stk group by usercode)
) as c2 on sb2.ucs=c2.ucc)

) as diff inner join (

(SELECT *, round(timediff(user.completed, user.created)/60) as minutes, abs(user.goal - user.totalvalue) as difference FROM user)

) as userall on userall.usercode=diff.usercode)

) as fulltable on assetavgs.usercodeavg=fulltable.usercode) as fulltable)

) as fulltable on deltas.uc2=fulltable.usercode
";

?>