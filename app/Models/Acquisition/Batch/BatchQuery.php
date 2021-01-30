<?php


namespace App\Models\Acquisition\Batch;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait BatchQuery
{
    public static function defaultQuery(): Builder
    {
        return static::query()->select('s.title_' . app()->getLocale() . ' as status', static::keyName() . ' as id', 'b.invoice_date as inv_date',
            'st.title_' . app()->getLocale() . ' as sup_type', 'st.key as sup_key', 'sp.supplier_name as supplier', 'b.supplier_id as sup_id', 'b.items_no as items_no',
            'b.titles_no as titles_no', 'b.doc_no as doc_no', 'b.contract_no', 'b.invoice_details as inv_details', 'b.create_date as create_date', 'b.cost',
            DB::raw("(select (e.name||' '||e.sname) from dbmaster.employee e where e.emp_id = b.user_id) as created_by"),
            DB::raw("(select (e.name||' '||e.sname) from dbmaster.employee e where e.emp_id = b.edited_by) as edited_by"))
            ->leftJoin('lib_batch_status as s', 'b.status', '=', 's.id')
            ->leftJoin('lib_supply_types as st', 'b.supply_type', '=', 'st.key')
            ->leftJoin('lib_suppliers as sp', 'b.supplier_id', '=', 'sp.supplier_id');
    }

}
