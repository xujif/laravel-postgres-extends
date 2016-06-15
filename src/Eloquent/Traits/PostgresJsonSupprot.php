<?php
namespace Xujif\LaravelPgSqlSchema\Eloquent\Traits;

use Illuminate\Database\Eloquent\Builder;

trait PostgresJsonSupport
{

    public function scopeWherePgJson(Builder $builder, $column, $operator, $value)
    {
        return $builder->whereRaw("$column $operator ?", [$value]);
    }
}
