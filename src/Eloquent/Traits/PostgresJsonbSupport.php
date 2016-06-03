<?php
namespace Xujif\LaravelPgSqlSchema\Eloquent\Traits;


trait PostgresJsonbSupport
{
    use PostgresJsonSupport;

    protected function _operatorToFun($operator)
    {
        $arr = [
            '?' => 'jsonb_exists($column,?)',
            '?|'=> 'jsonb_exists_any($column,?)',
            '?&'=> 'jsonb_exists_all($column,?)',
        ];
        return isset($arr[$operator]) ? $arr[$operator] : false;
    }

}