select * from ((select "D"."DISC_ID" as "ID",
"D"."NAME" as "TITLE",
"D"."PUB_YEAR" as "YEAR",
"P"."NAME" as "PUBLISHER",
"D"."LANGUAGE" as "LANGUAGE",
"MT"."TITLE_EN" as "TYPE",
"D"."TYPE" as "TYPE_KEY",
"D"."ISBN",
"D"."ISSN", (select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.disc_id = d.disc_id group by a.disc_id) as author, (case when (select r.disc_id from lib_reserve_list r
                            where d.disc_id = r.disc_id and r.status = 1) is not null
                            then (select 1 from dual) else (select 0 from dual) end) as status,
"D"."CALLNUMBER" as "CALL_NUMBER", (select count(*) from lib_inventory i where i.disc_id = d.disc_id and i.status = 1) as availability from "LIB_DISCS" d left join "LIB_PUBLISHERS" p on "P"."PUBLISHER_ID" = "D"."PUBLISHER_ID" left join "LIB_MATERIAL_TYPES" mt on "D"."TYPE" = "MT"."KEY") union all (select "J"."JOURNAL_ID" as "ID",
"J"."TITLE" as "TITLE",
"J"."PUB_YEAR" as "YEAR",
"P"."NAME" as "PUBLISHER",
"J"."LANGUAGE" as "LANGUAGE",
"MT"."TITLE_EN" as "TYPE",
"J"."TYPE" as "TYPE_KEY",
"J"."ISBN",
null as issn, (select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.j_issue_id = ji.j_issue_id group by a.j_issue_id) as author, (case when (select r.j_issue_id from lib_reserve_list r
                            where ji.j_issue_id = r.j_issue_id and r.status = 1) is not null
                            then (select 1 from dual) else (select 0 from dual) end) as status,
"J"."CALLNUMBER" as "CALL_NUMBER", (select count(*) from lib_inventory i where i.j_issue_id = ji.j_issue_id and i.status = 1) as availability from "LIB_JOURNALS" j left join "LIB_JOURNAL_ISSUES" ji on "J"."JOURNAL_ID" = "JI"."JOURNAL_ID" left join "LIB_PUBLISHERS" p on "P"."PUBLISHER_ID" = "J"."PUBLISHER_ID" left join "LIB_MATERIAL_TYPES" mt on "J"."TYPE" = "MT"."KEY")) where (lower(title) like '%math%') order by "ID" desc
