<?php

namespace App\Models\Acquisition\Publisher;

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

class Publisher extends Model implements Query, KeyName, LastCreated, Search, Autocomplete
{
    protected $table = 'lib_publishers as p';
    protected $primaryKey = 'p.publisher_id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['name', 'commercial_name', 'address'];

    const SORT_FIELDS = [['key' => 'id', 'title' => 'ID'],
        ['key' => 'name', 'title' => 'Name'],
        ['key' => 'com_name', 'title' => 'Commercial name'],
        ['key' => 'address', 'title' => 'Address'],
        ['key' => 'email', 'title' => 'E-mail'],
        ['key' => 'phone', 'title' => 'Phone number'],
        ['key' => 'fax', 'title' => 'Fax']];
    const LAST_QUERY_NAME = 'publishers_last_query';
    const CACHED_ID_NAME = 'publishers_cached';
    const CREATED_ID_NAME = 'created_publisher_id';

    use PublisherQuery;
    use KeyNameTrait;
    use LastCreatedTrait;
    use PublisherSearch;
    use FetchQuery;
    use PublisherAutocomplete;
    use PublisherAdditional;
    use ManageBuilder;
    use PublisherManage;
}
