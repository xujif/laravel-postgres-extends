<?php
namespace Xujif\LaravelPgSqlSchema\Eloquent\Traits;

use Illuminate\Database\Eloquent\Builder;
use Xujif\LaravelPgSqlSchema\Eloquent\Utils;
trait PostgresJsonbSupport
{

    protected function _operatorToFun($operator)
    {
        $arr = [
            '?' => 'jsonb_exists($column,?)',
            '?|' => 'jsonb_exists_any($column,?)',
            '?&' => 'jsonb_exists_all($column,?)',
        ];
        return isset($arr[$operator]) ? $arr[$operator] : false;
    }

    public function scopeWherePgJsonb(Builder $builder, $column, $operator, $value)
    {
        if (in_array($operator, ['?|', '?&'])) {
            $value = Utils::array2pgArray((array) $value);
        }
        $fun = $this->_operatorToFun($operator);
        if ($fun) {
            return $builder->whereRaw(str_replace('$column', $column, $fun), [$value]);
        }
        return $builder->whereRaw("$column $operator ?", [$value]);
    }
}
