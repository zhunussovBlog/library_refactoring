<?php

namespace App\Models\Acquisition\Supplier;

use App\Models\Acquisition\Common\FetchQuery;
use App\Models\Acquisition\Common\KeyName as KeyNameTrait;
use App\Models\Acquisition\Common\LastCreated as LastCreatedTrait;
use App\Models\Acquisition\Common\ManageBuilder;
use App\Models\Acquisition\Interfaces\Autocomplete;
use App\Models\Acquisition\Interfaces\KeyName;
use App\Models\Acquisition\Interfaces\LastCreated;
use App\Models\Acquisition\Interfaces\Query;
use App\Models\Acquisition\Interfaces\Search;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model implements Query, KeyName, LastCreated, Search, Autocomplete
{
    protected $table = 'lib_suppliers as s';
    protected $primaryKey = 's.supplier_id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['supplier_name', 'bin/inn', 'commercial_name', 'address'];

    const SORT_FIELDS = [['key' => 'id', 'title' => 'ID'],
        ['key' => 'name', 'title' => 'Name'],
        ['key' => 'com_name', 'title' => 'Commercial name'],
        ['key' => 'bin', 'title' => 'BIN'],
        ['key' => 'address', 'title' => 'Address'],
        ['key' => 'email', 'title' => 'E-mail'],
        ['key' => 'phone', 'title' => 'Phone number'],
        ['key' => 'fax', 'title' => 'Fax']];
    const LAST_QUERY_NAME = 'suppliers_last_query';
    const CACHED_ID_NAME = 'suppliers_cached';
    const CREATED_ID_NAME = 'created_supplier_id';

    use SupplierQuery;
    use KeyNameTrait;
    use LastCreatedTrait;
    use SupplierSearch;
    use FetchQuery;
    use SupplierAutocomplete;
    use SupplierAdditional;
    use ManageBuilder;
    use SupplierManage;
}
