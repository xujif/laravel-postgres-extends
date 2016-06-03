<?php
namespace Xujif\LaravelPgSqlSchema\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\PostgresGrammar as BaseGrammar;
use Illuminate\Support\Fluent;
use Xujif\LaravelPgSqlSchema\Schema\Blueprint;

class PostgresGrammar extends BaseGrammar
{

    protected $extra_types = [
        'json',
        'hstore',
        'uuid',
        'jsonb',
        'ipAddress',
        'netmask',
        'macAddress',
        'point',
        'line',
        'lineSegment',
        'path',
        'box',
        'polygon',
        'circle',
        'money',
        'int4range',
        'int8range',
        'numrange',
        'tsrange',
        'tstzrange',
        'daterange',
        'tsvector',
    ];

    /**
     * @param Fluent $column
     * @return string
     */
    protected function typeCharacter(Fluent $column)
    {
        return "character({$column->length})";
    }

    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        }
        if (preg_match('/^type(.+)Array$/', $method, $m)) {
            $t = $m[1];
            $fluent = $args[0];
            if (in_array($t, $this->extra_types) || method_exists($this, 'type' . ucfirst($t))) {
                return $t . $fluent->arrays;
            }
        }
        if (preg_match('/^type(.+)$/', $method, $m)) {
            $t = $m[1];
            if (in_array($t, $this->extra_types)) {
                return $t;
            }
        }
        throw new \BadMethodCallException("method {$method} not exists");
    }

    /**
     * @param Blueprint $blueprint
     * @param Fluent $command
     * @return mixed
     */
    public function compileGin(Blueprint $blueprint, Fluent $command)
    {
        $columns = $this->columnize($command->columns);
        return sprintf('CREATE INDEX %s ON %s USING GIN(%s)', $command->index, $this->wrapTable($blueprint), $columns);
    }
}
