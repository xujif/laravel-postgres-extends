<?php

namespace Xujif\LaravelPgSqlSchema\Schema;

use Closure;
use \Illuminate\Database\Schema\PostgresBuilder as BasePostgresBuilder;

class PostgresBuilder extends BasePostgresBuilder
{

    protected function createBlueprint($table, Closure $callback = null)
    {
        return new Blueprint($table, $callback);
    }
}
