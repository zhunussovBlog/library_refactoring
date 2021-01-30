<?php

namespace App\Models\Acquisition\Item;

use App\Models\Acquisition\Common\KeyName as KeyNameTrait;
use App\Models\Acquisition\Common\LastCreated as LastCreatedTrait;
use App\Models\Acquisition\Interfaces\KeyName;
use App\Models\Acquisition\Interfaces\LastCreated;
use App\Models\Acquisition\Interfaces\Query;
use App\Models\Acquisition\Interfaces\Search;
use Illuminate\Database\Eloquent\Model;

class Item extends Model implements Query, KeyName, LastCreated, Search
{
    protected $table = 'lib_inventory as i';
    protected $primaryKey = 'i.inv_id';
    public $timestamps = false;
    public $incrementing = false;

    const SORT_FIELDS = [['key' => 'barcode', 'title' => 'Barcode'],
        ['key' => 'inv_id', 'title' => 'Inventory No'],
        ['key' => 'batch_id', 'title' => 'Batch No'],
        ['key' => 'author', 'title' => 'Author'],
        ['key' => 'title', 'title' => 'Title'],
        ['key' => 'create_date', 'title' => 'Filled Date'],
        ['key' => 'created_by', 'title' => 'Created By'],
        ['key' => 'edited_by', 'title' => 'Edited By']];
    const LAST_QUERY_NAME = 'items_last_query';
    const CACHED_ID_NAME = 'items_cached';
    const CREATED_ID_NAME = 'created_item_id';
    const SEARCH_FIELDS = [['key' => 'author', 'title' => 'Author'],
        ['key' => 'title', 'title' => 'Title'],
        ['key' => 'barcode', 'title' => 'Barcode'],
        ['key' => 'batch_id', 'title' => 'Batch number'],
        ['key' => 'inv_id', 'title' => 'Inventory number'],
        ['key' => 'isbn', 'title' => 'ISBN']];

    use ItemQuery;
    use KeyNameTrait;
    use LastCreatedTrait;
    use ItemSearch;
    use ItemManage;
    use ItemAdditional;
    use ItemReports;
}
