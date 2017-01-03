<?php

namespace Xujif\LaravelPgSqlSchema;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use Xujif\LaravelPgSqlSchema\Connectors\ConnectionFactory;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {

        $this->app->singleton('db.connection.pgsql', function ($app, $params) {
            $rc = new \ReflectionClass(PostgresConnection::class);
            return $rc->newInstanceArgs($params);
        });

        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });
    }
}
