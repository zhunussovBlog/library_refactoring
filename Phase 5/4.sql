select "S"."TITLE_EN" as "STATUS",
"B"."STATUS" as "STATUS_KEY",
"B"."HESAB_ID" as "ID",
"B"."INVOICE_DATE",
"ST"."TITLE_EN" as "SUP_TYPE",
"ST"."KEY" as "SUP_KEY",
"SP"."SUPPLIER_NAME" as "SUPPLIER",
"B"."SUPPLIER_ID" as "SUP_ID",
"B"."ITEMS_NO" as "ITEMS_NO",
"B"."TITLES_NO" as "TITLES_NO",
"B"."DOC_NO" as "DOC_NO",
"B"."CONTRACT_NO",
"B"."INVOICE_DETAILS" as "INV_DETAILS",
"B"."CREATE_DATE" as "CREATE_DATE",
"B"."EDIT_DATE",
"B"."COST", (select (e.name||' '||e.sname) from dbmaster.employee e where e.emp_id = b.user_id) as created_by,
       (select (e.name||' '||e.sname) from dbmaster.employee e where e.emp_id = b.edited_by) as edited_by
from "LIB_HESABLAR" b left join "LIB_BATCH_STATUS" s on "B"."STATUS" = "S"."ID"
    left join "LIB_SUPPLY_TYPES" st on "B"."SUPPLY_TYPE" = "ST"."KEY"
    left join "LIB_SUPPLIERS" sp on "B"."SUPPLIER_ID" = "SP"."SUPPLIER_ID"
