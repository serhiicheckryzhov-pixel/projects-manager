<?php

namespace App\Http\Filters\V1;

class UserFilter extends QueryFilter
{
    public function include()
    {
        return $this->builder->with($this->request->get('include'));
    }

    public function email($value)
    {
        return $this->builder->where('email', 'like', "%{$value}%");
    }

    public function name($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }
}
