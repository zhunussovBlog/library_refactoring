select (case when i.book_id is not null then i.book_id
        when i.disc_id is not null then i.disc_id
        when i.j_issue_id is not null then i.j_issue_id end) as id, (case when i.book_id is not null
    then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
            from lib_book_authors a where a.book_id = i.book_id)
    when i.j_issue_id is not null
    then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
            from lib_book_authors a where a.j_issue_id = i.j_issue_id)
    when i.disc_id is not null
    then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
            from lib_book_authors a where a.disc_id = i.disc_id)
             end) as author, (case when i.book_id is not null
    then (select b.title from lib_books b where b.book_id = i.book_id)
    when i.j_issue_id is not null
    then (select j.title from lib_journals j
            left join lib_journal_issues ji on j.journal_id = ji.journal_id
            where ji.j_issue_id = i.j_issue_id)
    when i.disc_id is not null
    then (select d.name from lib_discs d where d.disc_id = i.disc_id) end) as title, (case when i.book_id is not null
    then (select b.language from lib_books b where b.book_id = i.book_id)
    when i.disc_id is not null
    then (select d.language from lib_discs d where d.disc_id = i.disc_id)
    when i.j_issue_id is not null
    then (select j.language from lib_journals j
            left join lib_journal_issues ji on j.journal_id = ji.journal_id
            where ji.j_issue_id = i.j_issue_id) end) as language, (case when i.book_id is not null
    then (select b.isbn from lib_books b where b.book_id = i.book_id)
    when i.j_issue_id is not null
    then (select j.isbn from lib_journals j
            left join lib_journal_issues ji on j.journal_id = ji.journal_id
            where ji.j_issue_id = i.j_issue_id)
    when i.disc_id is not null
    then (select d.isbn from lib_discs d where d.disc_id = i.disc_id) end) as isbn, count(l.loan_id) as count_issue from "LIB_LOANS" l left join "LIB_INVENTORY" i on "L"."INV_ID" = "I"."INV_ID" group by "I"."BOOK_ID",
"I"."DISC_ID",
"I"."J_ISSUE_ID" order by "COUNT_ISSUE" desc
