<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    protected Builder $builder;
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = request();
    }

    /**
     * Apply filters to the query builder.
     * 1. Get all query parameters
     * 2. Loop through each parameter and call the corresponding method on the class
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder) : Builder
    {
        $this->builder = $builder;

        foreach (request()->query() as $key => $value) {
            if (method_exists($this, $key)){
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    /**
     * Applies a series of filters to modify the query builder using methods available in the current class.
     *
     * @param array $filters An associative array where the keys are method names and the values are parameters to be passed to the methods.
     * @return mixed Returns the modified query builder instance.
     */
    protected function filter(array $filters)
    {
        foreach ($filters as $filter => $value) {
            if (method_exists($this, $filter)){
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Sorts the query builder results based on the specified sort attribute and direction.
     *
     * @param string $sort A comma-separated string where the first value is the attribute to sort by and the second optional value is the direction ('asc' or 'desc').
     * @return mixed Returns the modified query builder instance.
     */
    protected function sort(string $sort)
    {
        $sortAttributes = explode(',', $sort);
        if (isset($sortAttributes[0])) {
            return $this->builder->orderBy($sortAttributes[0], $sortAttributes[1] ?? 'asc');
        }

        return $this->builder;
    }
}
