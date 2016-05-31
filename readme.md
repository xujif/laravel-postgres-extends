

#Laravel Postgresql schama extends  


####usage:
```
 Schema::create('table', function (Blueprint $table) {
    $table->increments('id');
    $table->jsonb('fields');
    $table->circle('fields');
    $table->textArray('fieldsOfArray'); //type of text[]
    $table->integerArray('integerArray'); //type of text[]
});
```


##supprts types 
```php
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
```

 