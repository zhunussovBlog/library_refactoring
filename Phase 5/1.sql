select "B"."BOOK_ID" as "ID",
    "B"."TITLE" as "TITLE",
    "B"."PUB_YEAR" as "YEAR",
    "P"."NAME" as "PUBLISHER",
    "B"."LANGUAGE" as "LANGUAGE",
    "MT"."TITLE_EN" as "TYPE",
    "B"."TYPE" as "TYPE_KEY",
    "B"."ISBN",
    (select listagg(a.name||a.surname, ', ') within group(order by a.name)
        from lib_book_authors a where a.book_id = b.book_id group by a.book_id) as author, (case when (select r.book_id from lib_reserve_list r
        where b.book_id = r.book_id and r.status = 1) is not null
    then (select 1 from dual) else (select 0 from dual) end) as status,
    "B"."CALLNUMBER" as "CALL_NUMBER",
  (select count(*) from lib_inventory i where i.book_id = b.book_id and i.status = 1) as availability from "LIB_BOOKS" b left join "LIB_PUBLISHERS" p on "P"."PUBLISHER_ID" = "B"."PUBLISHER_ID" left join "LIB_MATERIAL_TYPES" mt on "B"."TYPE" = "MT"."KEY" where lower(b.title) like '%sherlock%' order by "ID" desc
