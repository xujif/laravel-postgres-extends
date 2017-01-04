<?php

namespace Xujif\LaravelPgSqlSchema;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use Xujif\LaravelPgSqlSchema\Connectors\ConnectionFactory;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bind('db.connection.pgsql', PostgresConnection::class);
    }
}
