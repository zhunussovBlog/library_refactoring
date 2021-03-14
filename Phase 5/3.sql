select "I"."BARCODE", "I"."INV_ID" as "ID", "I"."HESAB_ID" as "BATCH_ID", (case when i.book_id is not null
then (select b.title from lib_books b where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select j.title from lib_journals j
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select d.name from lib_discs d where d.disc_id = i.disc_id) end) as title, (case when i.book_id is not null
then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
from lib_book_authors a where a.book_id = i.book_id)
when i.j_issue_id is not null
then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
from lib_book_authors a where a.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
from lib_book_authors a where a.disc_id = i.disc_id)
end) as author, (case when i.book_id is not null
then (select b.isbn from lib_books b where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select j.isbn from lib_journals j
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select d.isbn from lib_discs d where d.disc_id = i.disc_id) end) as isbn, (case when i.book_id is not null
then (select b.pub_year from lib_books b where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select j.pub_year from lib_journals j
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select d.pub_year from lib_discs d where d.disc_id = i.disc_id) end) as pub_year, (case when i.book_id is not null
then (select b.pub_city from lib_books b where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select j.pub_city from lib_journals j
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select d.pub_city from lib_discs d where d.disc_id = i.disc_id) end) as pub_city, (case when i.book_id is not null
then (select mt.key||' - '||mt.title_en from lib_material_types mt
left join lib_books b on mt.key = b.type where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select mt.key||' - '||mt.title_en from lib_material_types mt
left join lib_journals j on mt.key = j.type
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select mt.key||' - '||mt.title_en from lib_material_types mt
left join lib_discs d on mt.key = d.type where d.disc_id = i.disc_id)
end) as item_type, (case when i.book_id is not null
then (select mt.key from lib_material_types mt
left join lib_books b on mt.key = b.type where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select mt.key from lib_material_types mt
left join lib_journals j on mt.key = j.type
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select mt.key from lib_material_types mt
left join lib_discs d on mt.key = d.type where d.disc_id = i.disc_id)
end) as item_key, (case when i.book_id is not null
then (select p.name from lib_publishers p
left join lib_books b on p.publisher_id = b.publisher_id where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select p.name from lib_publishers p
left join lib_journals j on p.publisher_id = j.publisher_id
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select p.name from lib_publishers p
left join lib_discs d on p.publisher_id = d.publisher_id
where d.disc_id = i.disc_id)
end) as publisher, (case when i.book_id is not null
then (select p.publisher_id from lib_publishers p
left join lib_books b on p.publisher_id = b.publisher_id where b.book_id = i.book_id)
when i.j_issue_id is not null
then (select p.publisher_id from lib_publishers p
left join lib_journals j on p.publisher_id = j.publisher_id
left join lib_journal_issues ji on j.journal_id = ji.journal_id
where ji.j_issue_id = i.j_issue_id)
when i.disc_id is not null
then (select p.publisher_id from lib_publishers p
left join lib_discs d on p.publisher_id = d.publisher_id
where d.disc_id = i.disc_id)
end) as publisher_id, (select s.supplier_name from lib_suppliers s
left join lib_hesablar h on s.supplier_id = h.supplier_id where h.hesab_id = i.hesab_id) as supplier, (select
h.supplier_id from lib_hesablar h where h.hesab_id = i.hesab_id) as supplier_id, (select spt.title_en from
lib_supply_types spt
left join lib_hesablar h on spt.key = h.supply_type where h.hesab_id = i.hesab_id) as sup_type, (select (case when
u.emp_id is not null
then (select e.name||' '||e.sname from dbmaster.employee e where e.emp_id = u.emp_id) end)
from lib_user_cards u where u.user_cid = i.user_cid) as created_by, (select (case when u.emp_id is not null
then (select e.name||' '||e.sname from dbmaster.employee e where e.emp_id = u.emp_id) end)
from lib_user_cards u where u.user_cid = i.edited_by) as edited_by, "I"."PRICE" as "COST", "I"."CURRENCY",
TO_CHAR(i.receive_date, 'YYYY-MM-DD') as create_date, st.key||' - '||st.title_en as location_title, "ST"."KEY" as
"LOCATION", "I"."USER_CID" from "LIB_INVENTORY" i left join "SIGLE_TYPES" st on "ST"."KEY" = "I"."SIGLE_TYPE"
