<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait EloquentFilterTrait
{
    /**
     * filterForm()
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterForm($query)
    {
        $allows = self::FIELDS_ALLOW_QUERY;
        $filters = array_filter(request()->except(['sort_by']));
        foreach ($filters as $key => $filter) {
            if ( isset($allows[$key]) ) {
                $field = $allows[$key];
                $filter = $this->parseValue($field, $filter);
                if (count($field['attribute']) == 1) {
                    $attribute = array_shift($field['attribute']);
                    $query = $this->mapOperatorQuery($query, $attribute, $field['operator'], $filter);
                }
                if (count($field['attribute']) > 1) {
                    $query = $query->where(function($q) use ($field, $filter) {
                        foreach ($field['attribute'] as $key => $attribute) {
                            $query = $this->mapOperatorOrQuery($q, $attribute, $field['operator'], $filter);
                        }
                    });
                }
            }
        }
        return $query;
    }

    private function parseValue($field, $filter)
    {
        try {
            if (array_key_exists('type', $field) && $field['type'] == 'datetime') {
                if ($field['operator'] == '>=') {
                    $filter = date_format(date_create($filter.' 00:00:00'),"Y-m-d H:i:s");
                }
                if ($field['operator'] == '<=') {
                    $filter = date_format(date_create($filter.' 23:59:59'),"Y-m-d H:i:s");
                }
            }
            if (array_key_exists('type', $field) && $field['type'] == 'utc_datetime') {
                $filter = Carbon::parse($filter)->format('Y-m-d H:i:s');
            }
        } catch (\Exception $e) {
        }
        return $filter;
    }

    /**
     * MapOperatorQuery
     *
     * @param  array|string  $fields    Fields To filter
     * @param  string|null   $operator  Operator
     * @param  string|int    $input     Input request
     *
     * @return Builder
     */
    private function mapOperatorQuery($query, $field, $operator, $input)
    {
        switch ($operator) {
            case 'like':
                $query = $query->where($field, 'like', "%$input%");
                break;
            case '=':
                $query = $query->where($field, '=', $input);
                break;
            default:
                $query = $query->where($field, $operator, $input);
                break;
        }
        return $query;
    }

    /**
     * MapOperatorQuery
     *
     * @param  array|string  $fields    Fields To filter
     * @param  string|null   $operator  Operator
     * @param  string|int    $input     Input request
     *
     * @return Builder
     */
    private function mapOperatorOrQuery($query, $field, $operator, $input)
    {
        switch ($operator) {
            case 'like':
                $query = $query->orWhere($field, 'like', "%$input%");
                break;
            case '=':
                $query = $query->orWhere($field, '=', $input);
                break;
            default:
                $query = $query->orWhere($field, $operator, $input);
                break;
        }
        return $query;
    }

    /**
     * handleSort()
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHandleSort($query)
    {
        $sortBy = request()->sort_by; // ['id', 'desc']
        if ( $sortBy && is_array($sortBy) && count($sortBy) == 2 ) {
            if (isset(self::FIELDS_ALLOW_QUERY[$sortBy[0]])) {
                $orders = self::FIELDS_ALLOW_QUERY[$sortBy[0]];
                $sort = strtolower($sortBy[1]) === 'desc' ? 'desc' : 'asc';
                foreach ($orders['attribute'] as $key => $order) {
                    $query = $query->orderBy($order, $sort);
                }
            }
        } else {
            $query = $query->orderBy(self::ORDER_DEFAULT[0], self::ORDER_DEFAULT[1]);
        }

        return $query;
    }
}
