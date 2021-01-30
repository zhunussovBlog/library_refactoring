<?php


namespace App\Models\Acquisition\Item;


use App\Exceptions\ReturnResponseException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ItemSearch
{
    public static function search(array $validated): Builder
    {
        $data = static::defaultQuery();

        if (isset($validated['search_options'])) {
            // Search by fields coming from array
            $searchOptions = $validated['search_options'];

            $data = static::requiredSearchBuilder($data, $searchOptions);
        }

        // Additional search
        $data = static::filterSearchBuilder($data, $validated);

        return $data;
    }

    private static function requiredSearchBuilder(Builder $data, array $options): Builder
    {
        $data = $data->where(static function ($query) use ($options) {
            foreach ($options as $option) {
                if (empty($option['key']) || empty($option['value'])) break;
                $isAnd = $option['operator'] === 'and';
                $value = $option['value'];
                switch ($option['key']) {
                    case 'author':
                        $raw = function ($nestedQuery) use ($value) {
                            $nestedQuery->where(DB::raw("(select lower(listagg(a.name||a.surname, ', ') within group(order by a.name))
                                        from lib_book_authors a where a.book_id = i.book_id)"), 'like',
                                '%' . mb_strtolower($value) . '%');
                            $nestedQuery->orWhere(DB::raw("(select lower(listagg(a.name||a.surname, ', ') within group(order by a.name))
                                        from lib_book_authors a where a.j_issue_id = i.j_issue_id)"), 'like',
                                '%' . mb_strtolower($value) . '%');
                            $nestedQuery->orWhere(DB::raw("(select lower(listagg(a.name||a.surname, ', ') within group(order by a.name))
                                        from lib_book_authors a where a.disc_id = i.disc_id)"), 'like',
                                '%' . mb_strtolower($value) . '%');
                        };
                        $query = $isAnd ? $query->where($raw) : $query->orWhere($raw);
                        break;
                    case 'title':
                        $raw = function ($nestedQuery) use ($value) {
                            $nestedQuery->where(DB::raw('(select lower(b.title) from lib_books b where b.book_id = i.book_id)'), 'like',
                                '%' . mb_strtolower($value) . '%');
                            $nestedQuery->orWhere(DB::raw('(select lower(j.title) from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)'),
                                'like', '%' . mb_strtolower($value) . '%');
                            $nestedQuery->orWhere(DB::raw('(select lower(d.name) from lib_discs d where d.disc_id = i.disc_id)'),
                                'like', '%' . mb_strtolower($value) . '%');
                        };

                        $query = $isAnd ? $query->where($raw) : $query->orWhere($raw);
                        break;
                    case 'barcode':
                        $query = $isAnd ? $query->where('i.barcode', '=', $value) : $query->orWhere('i.barcode', '=', $value);
                        break;
                    case 'batch_id':
                        $query = $isAnd ? $query->where('i.hesab_id', '=', $value) : $query->orWhere('i.hesab_id', '=', $value);
                        break;
                    case 'inv_id':
                        $query = $isAnd ? $query->where('i.inv_id', '=', $value) : $query->orWhere('i.inv_id', '=', $value);
                        break;
                    case 'isbn':
                        $raw = function ($nestedQuery) use ($value) {
                            $nestedQuery->where(DB::raw('(select b.isbn from lib_books b where b.book_id = i.book_id)'),
                                '=', $value);
                            $nestedQuery->orWhere(DB::raw('(select j.isbn from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)'),
                                '=', $value);
                            $nestedQuery->orWhere(DB::raw('(select d.isbn from lib_discs d where d.disc_id = i.disc_id)'),
                                '=', $value);
                        };

                        $query = $isAnd ? $query->where($raw) : $query->orWhere($raw);
                        break;
                    default:
                        throw new ReturnResponseException('Incorrect type field', 400);
                }
            }
            return $query;
        });

        return $data;
    }

    private static function filterSearchBuilder(Builder $data, array $attributes): Builder
    {
        if (!empty($attributes['publisher_id'])) {
            $data = $data->where(static function ($query) use ($attributes) {
                $query->where(DB::raw("(select p.publisher_id from lib_publishers p
                                        left join lib_books b on p.publisher_id = b.publisher_id where b.book_id = i.book_id)"),
                    '=', $attributes['publisher_id']);
                $query->orWhere(DB::raw("(select p.name from lib_publishers p
                                        left join lib_journals j on p.publisher_id = j.publisher_id
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)"),
                    '=', $attributes['publisher_id']);
                $query->orWhere(DB::raw("(select p.name from lib_publishers p
                                        left join lib_discs d on p.publisher_id = d.publisher_id
                                        where d.disc_id = i.disc_id)"),
                    '=', $attributes['publisher_id']);
            });
        }

        if (!empty($attributes['pub_year'])) {
            $data = $data->where(static function ($query) use ($attributes) {
                $query->where(DB::raw("(select b.pub_year from lib_books b where i.book_id = b.book_id)"),
                    '=', $attributes['pub_year']);
                $query->orWhere(DB::raw("(select d.pub_year from lib_discs d where i.disc_id = d.disc_id)"),
                    '=', $attributes['pub_year']);
                $query->orWhere(DB::raw("(select j.pub_year from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)"),
                    '=', $attributes['pub_year']);
            });
        }

        if (!empty($attributes['pub_city'])) {
            $data = $data->where(static function ($query) use ($attributes) {
                $query->where(DB::raw("lower((select b.pub_city from lib_books b where i.book_id = b.book_id))"),
                    'like', '%' . mb_strtolower($attributes['pub_city']) . '%');
                $query->orWhere(DB::raw("lower((select d.pub_city from lib_discs d where i.disc_id = d.disc_id))"),
                    'like', '%' . mb_strtolower($attributes['pub_city']) . '%');
                $query->orWhere(DB::raw("lower((select j.pub_city from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id))"),
                    'like', '%' . mb_strtolower($attributes['pub_city']) . '%');
            });
        }

        if (!empty($attributes['supplier_id'])) {
            $data = $data->where(DB::raw("(select h.supplier_id from lib_hesablar h where h.hesab_id = i.hesab_id)"),
                '=', $attributes['supplier_id']);
        }

        if (!empty($attributes['sup_type'])) {
            $data = $data->where(DB::raw("(select h.supply_type from lib_hesablar h where h.hesab_id = i.hesab_id)"),
                '=', $attributes['sup_type']);
        }

        if (!empty($attributes['location'])) {
            $data = $data->where('st.key', '=', $attributes['location']);
        }

        if (!empty($attributes['item_type'])) {
            $data = $data->where(static function ($query) use ($attributes) {
                $query->where(DB::raw("(select mt.key from lib_material_types mt
                                        left join lib_books b on mt.key = b.type where b.book_id = i.book_id)"),
                    '=', $attributes['item_type']);
                $query->orWhere(DB::raw("(select mt.key from lib_material_types mt
                                        left join lib_journals j on mt.key = j.type
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)"),
                    '=', $attributes['item_type']);
                $query->orWhere(DB::raw("(select mt.key from lib_material_types mt
                                        left join lib_discs d on mt.key = d.type where d.disc_id = i.disc_id)"),
                    '=', $attributes['item_type']);
            });
        }

        if (!empty($attributes['user_cid'])) {
            $data = $data->where('i.user_cid', '=', $attributes['user_cid']);
        }

        if (!empty($attributes['start_date']) && !empty($attributes['end_date'])) {
            $data = $data->whereBetween('i.receive_date',
                [$attributes['start_date'], $attributes['end_date']]);
        } else if (!empty($attributes['start_date'])) {
            $data = $data->whereRaw("i.receive_date >= to_date(?, 'YYYY-MM-DD')",
                [$attributes['start_date']]);
        } else if (!empty($attributes['end_date'])) {
            $data = $data->whereRaw("i.receive_date <= to_date(?, 'YYYY-MM-DD')",
                [$attributes['end_date']]);
        }

        if (!empty($attributes['from_cost']) && !empty($attributes['until_cost'])) {
            $data = $data->whereBetween('i.price',
                [$attributes['from_cost'], $attributes['until_cost']]);
        } else if (!empty($attributes['from_cost'])) {
            $data = $data->whereRaw("i.price >= ?",
                [$attributes['from_cost']]);
        } else if (!empty($attributes['until_cost'])) {
            $data = $data->whereRaw("i.price <= ?",
                [$attributes['until_cost']]);
        }

        return $data;
    }
}
