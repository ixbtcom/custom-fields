<?php

use Webkul\CustomFields\Policies\FieldPolicy;

it('exposes every CRUD + soft-delete permission method', function () {
    $reflection = new ReflectionClass(FieldPolicy::class);

    $methods = collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
        ->map(fn ($m) => $m->getName())
        ->all();

    foreach ([
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
        'deleteAny',
        'forceDelete',
        'forceDeleteAny',
        'restore',
        'restoreAny',
    ] as $expected) {
        expect($methods)->toContain($expected);
    }
});
