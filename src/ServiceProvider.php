<?php

namespace Xujif\LaravelPgSqlSchema;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {

        $this->app->singleton('db.connection.pgsql', function ($app, $params) {
            $rc = new \ReflectionClass(PostgresConnection::class);
            return $rc->newInstanceArgs($params);
        });
    }
}
