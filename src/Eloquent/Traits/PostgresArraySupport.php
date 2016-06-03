<?php
namespace Xujif\LaravelPgSqlSchema\Eloquent\Traits;

use Illuminate\Database\Eloquent\Builder;
use Xujif\LaravelPgSqlSchema\Eloquent\Utils;

class PostgresArraySupport
{

    protected function _getAttributeOfPgArray($key)
    {
        return Utils::pgArray2array($this->attributes[$key]);
    }

    protected function _setAttributeOfPgArray($key, $value, $array_depth = 1)
    {
        return $this->attributes[$key] = Utils::array2pgArray($value, $array_depth);
    }

    public function array2PgArray($v)
    {
        return Utils::array2pgArray($v);
    }

    public function scopeWherePgArray(Builder $query, $column, $operator, $value)
    {
        $value = is_array($value) ? Utils::array2pgArray($value) : $value;
        return $query->whereRaw("\"$column\" $operator ?", [$value]);
    }

    /**
     * @param Builder $query
     * @param $column
     * @param $value
     * @return mixed
     */
    public function scopeWherePgArrayContains(Builder $query, $column, $value)
    {
        $value = (array)$value;
        $value = self::array2pgArray($value);
        return $query->whereRaw("\"$column\" @> ?", [$value]);
    }

    /**
     * @param Builder $query
     * @param $column
     * @param $value
     * @return mixed
     */
    public function scopeWherePgArrayOverlap(Builder $query, $column, $value)
    {
        $value = (array)$value;
        $value = self::array2pgArray($value);
        return $query->whereRaw("\"$column\" && ?", [$value]);
    }

}