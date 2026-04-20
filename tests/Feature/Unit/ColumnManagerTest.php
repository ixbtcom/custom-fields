<?php

use Webkul\CustomFields\CustomFieldsColumnManager;

it('exposes create/update/delete static methods', function () {
    $reflection = new ReflectionClass(CustomFieldsColumnManager::class);

    $methods = collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC))
        ->map(fn ($m) => $m->getName())
        ->all();

    expect($methods)->toContain('createColumn');
    expect($methods)->toContain('updateColumn');
    expect($methods)->toContain('deleteColumn');
});
