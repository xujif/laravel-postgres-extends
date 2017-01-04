<?php
namespace Xujif\LaravelPgSqlSchema;

use Illuminate\Database\PostgresConnection as BasePostgresConnection;
use Xujif\LaravelPgSqlSchema\Schema\PostgresBuilder;
use Xujif\LaravelPgSqlSchema\Schema\Grammars\PostgresGrammar;

class PostgresConnection extends BasePostgresConnection
{
    /**
     * Get a schema builder instance for the connection.
     *
     * @return Schema\Builder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }
        return new PostgresBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new PostgresGrammar);
    }

}
