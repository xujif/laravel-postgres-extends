<?php
namespace Xujif\LaravelPgSqlSchema\Schema;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
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
     * Add the index commands fluently specified on columns.
     *
     * @return void
     */
    protected function addFluentIndexes()
    {
        foreach ($this->columns as $column) {
            foreach (array('primary', 'unique', 'index', 'gin') as $index) {
                // If the index has been specified on the given column, but is simply
                // equal to "true" (boolean), no name has been specified for this
                // index, so we will simply call the index methods without one.
                if ($column->$index === true) {
                    $this->$index($column->name);
                    continue 2;
                }
                // If the index has been specified on the column and it is something
                // other than boolean true, we will assume a name was provided on
                // the index specification, and pass in the name to the method.
                elseif (isset($column->$index)) {
                    $this->$index($column->name, $column->$index);
                    continue 2;
                }
            }
        }
    }

    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        }
        /**
         * xxxArray('field','[]')
         */
        if (preg_match('/^(.+)Array$/', $method, $m)) {
            $t = $m[1];
            $column = array_shift($args);
            $arrays = isset($args[1]) ? $args[1] : '[]';
            //shift columt
            return $this->addColumn($t . 'Array', $column, compact('arrays'));
        }
        if (in_array($method, $this->extra_types)) {
            $column = array_shift($args);
            //shift columt
            return $this->addColumn($method, $column, $args);
        }
        throw new \BadMethodCallException("method {$method} not exists");
    }

    /**
     * create a gin index
     *
     * @param  string|array $columns
     * @param  string $name
     * @return \Illuminate\Support\Fluent
     */
    public function gin($columns, $name = null)
    {
        return $this->indexCommand('gin', $columns, $name);
    }

    public function character($column, $length = 255)
    {
        return $this->addColumn('character', $column, compact('length'));
    }

}
