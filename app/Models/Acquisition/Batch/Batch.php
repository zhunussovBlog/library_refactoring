<?php

namespace App\Models\Acquisition\Batch;

use App\Models\Acquisition\Common\KeyName as KeyNameTrait;
use App\Models\Acquisition\Common\LastCreated as LastCreatedTrait;
use App\Models\Acquisition\Common\ManageBuilder;
use App\Models\Acquisition\Interfaces\KeyName;
use App\Models\Acquisition\Interfaces\LastCreated;
use App\Models\Acquisition\Interfaces\Query;
use App\Models\Acquisition\Interfaces\Search;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model implements Query, KeyName, LastCreated, Search
{
    protected $table = 'lib_hesablar as b';
    protected $primaryKey = 'b.hesab_id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'invoice_date', 'create_date', 'items_no', 'titles_no', 'doc_no',
        'supply_type', 'supplier_id', 'contract_no', 'invoice_details', 'cost', 'user_id',
    ];

    const SORT_FIELDS = [['key' => 'create_date', 'title' => 'Filled Date'],
        ['key' => 'status', 'title' => 'Status'],
        ['key' => 'id', 'title' => 'Batch number'],
        ['key' => 'items_no', 'title' => 'Quantity of items'],
        ['key' => 'titles_no', 'title' => 'Quantity of titles'],
        ['key' => 'created_by', 'title' => 'Created by'],
        ['key' => 'edited_by', 'title' => 'Edited by']];
    const LAST_QUERY_NAME = 'batches_last_query';
    const CACHED_ID_NAME = 'batches_cached';
    const CREATED_ID_NAME = 'created_batch_id';

    use BatchQuery;
    use KeyNameTrait;
    use LastCreatedTrait;
    use BatchSearch;
    use ManageBuilder;
    use BatchManage;
    use BatchAdditional;
}
