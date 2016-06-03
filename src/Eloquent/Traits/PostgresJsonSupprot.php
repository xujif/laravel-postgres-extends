<?php
namespace Xujif\LaravelPgSqlSchema\Eloquent\Traits;

use Illuminate\Database\Eloquent\Builder;
use Xujif\LaravelPgSqlSchema\Eloquent\Utils;

trait PostgresJsonSupport
{
    protected function _operatorToFun($operator)
    {
        $arr = [
            '?' => 'json_exists($column,?)',
            '?|'=> 'json_exists_any($column,?)',
            '?&'=> 'json_exists_all($column,?)',
        ];
        return isset($arr[$operator]) ? $arr[$operator] : false;
    }



    public function scopeWherePgJson(Builder $builder, $column, $operator, $value)
    {
        if (in_array($operator, ['?|', '?&'])) {
            $value = Utils::array2pgArray($value);
        }
        $fun = $this->_operatorToFun($operator);
        if ($fun) {
            return $builder->whereRaw(str_replace('$column', $column, $fun), [$value]);
        }
        return $builder->whereRaw("$column $operator ?", [$value]);
    }
}