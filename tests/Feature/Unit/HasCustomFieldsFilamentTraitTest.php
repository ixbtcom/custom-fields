<?php

use Webkul\CustomFields\Filament\Concerns\HasCustomFields;

it('trait exists at expected namespace', function () {
    expect(trait_exists(HasCustomFields::class))->toBeTrue();
});

it('declares all five merge helpers', function () {
    $reflection = new ReflectionClass(HasCustomFields::class);

    $methods = collect($reflection->getMethods())->map(fn ($m) => $m->getName())->all();

    expect($methods)->toContain('mergeCustomFormFields');
    expect($methods)->toContain('mergeCustomTableColumns');
    expect($methods)->toContain('mergeCustomTableFilters');
    expect($methods)->toContain('mergeCustomTableQueryBuilderConstraints');
    expect($methods)->toContain('mergeCustomInfolistEntries');
});

it('merge helpers combine base + custom schemas', function () {
    $host = new class {
        use HasCustomFields {
            mergeCustomFormFields as public publicMergeCustomFormFields;
        }

        // Stub out the query-backed helper so the test doesn't hit the DB.
        protected static function getCustomFormFields(array $include = [], array $exclude = []): array
        {
            return ['custom_a', 'custom_b'];
        }
    };

    $merged = $host::publicMergeCustomFormFields(['base_1', 'base_2']);

    expect($merged)->toBe(['base_1', 'base_2', 'custom_a', 'custom_b']);
});
