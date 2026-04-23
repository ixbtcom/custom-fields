<?php

use Webkul\CustomFields\CustomFieldsColumnManager;
use Webkul\CustomFields\Models\Field;

it('exposes create/update/delete static methods', function () {
    $reflection = new ReflectionClass(CustomFieldsColumnManager::class);

    $methods = collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC))
        ->map(fn ($m) => $m->getName())
        ->all();

    expect($methods)->toContain('createColumn');
    expect($methods)->toContain('updateColumn');
    expect($methods)->toContain('deleteColumn');
});

it('maps star_rating field type to integer DB column', function () {
    $reflection = new ReflectionClass(CustomFieldsColumnManager::class);
    $method = $reflection->getMethod('getColumnType');
    $method->setAccessible(true);

    $field = (new Field())->forceFill([
        'code'              => 'score',
        'type'              => 'star_rating',
        'input_type'        => null,
        'is_multiselect'    => false,
        'customizable_type' => 'App\\Models\\Stub',
    ]);

    $columnType = $method->invoke(null, $field);

    expect($columnType)->toBe('integer');
});
