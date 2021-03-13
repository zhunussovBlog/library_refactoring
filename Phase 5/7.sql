select trim(to_char(wl.log_date, 'day')) as name, count(uc.stud_id) as count
from "WEB_LOG" wl left join "LIB_USER_CARDS" uc on "WL"."USER_ID" = "UC"."USER_CID"
where "WL"."LOG_DATE" between to_date((next_day(sysdate, 'MON'))-7)
and to_date((next_day(sysdate, 'MON')-1)) group by to_char(wl.log_date, 'day')

select trim(to_char(wl.log_date, 'month')) as name, count(uc.stud_id) as count
from "WEB_LOG" wl left join "LIB_USER_CARDS" uc on "WL"."USER_ID" = "UC"."USER_CID"
where to_char(wl.log_date, 'YYYY') = to_char(sysdate, 'YYYY') group by to_char(wl.log_date, 'month')
