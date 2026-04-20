<?php

use Webkul\CustomFields\Models\Field;

it('points at custom_fields table', function () {
    expect((new Field)->getTable())->toBe('custom_fields');
});

it('has the expected fillable attributes', function () {
    $fillable = (new Field)->getFillable();

    expect($fillable)->toContain('code');
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('type');
    expect($fillable)->toContain('input_type');
    expect($fillable)->toContain('is_multiselect');
    expect($fillable)->toContain('datalist');
    expect($fillable)->toContain('options');
    expect($fillable)->toContain('form_settings');
    expect($fillable)->toContain('use_in_table');
    expect($fillable)->toContain('table_settings');
    expect($fillable)->toContain('infolist_settings');
    expect($fillable)->toContain('sort');
    expect($fillable)->toContain('customizable_type');
});

it('casts json and boolean columns correctly', function () {
    $casts = (new Field)->getCasts();

    expect($casts['is_multiselect'])->toBe('boolean');
    expect($casts['options'])->toBe('array');
    expect($casts['form_settings'])->toBe('array');
    expect($casts['table_settings'])->toBe('array');
    expect($casts['infolist_settings'])->toBe('array');
});

it('uses soft deletes', function () {
    $uses = class_uses_recursive(Field::class);

    expect($uses)->toContain(Illuminate\Database\Eloquent\SoftDeletes::class);
});

it('is sortable on the "sort" column with auto-assign on create', function () {
    $field = new Field;

    expect($field->sortable['order_column_name'])->toBe('sort');
    expect($field->sortable['sort_when_creating'])->toBeTrue();
});
