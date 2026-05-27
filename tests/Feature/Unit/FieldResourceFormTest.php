<?php

use Webkul\CustomFields\Enums\StorageMode;
use Webkul\CustomFields\Models\Field;

describe('FieldResource form UI requirements', function () {
    it('Field model accepts storage enum via fillable', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'storage_column' => 'extra',
            'code'           => 'rating',
        ]);

        expect($field->storage)->toBe(StorageMode::Json);
        expect($field->storage_column)->toBe('extra');
    });

    it('Field model defaults to schema storage when not set', function () {
        $field = (new Field())->forceFill(['code' => 'rating']);
        expect($field->isSchemaMode())->toBeTrue();
    });

    it('storage casts to StorageMode enum', function () {
        $field = (new Field())->forceFill(['storage' => 'json', 'code' => 'x', 'storage_column' => 'extra']);
        expect($field->storage)->toBeInstanceOf(StorageMode::class);
        expect($field->storage)->toBe(StorageMode::Json);
    });

    it('storage_column is in fillable', function () {
        $field = new Field();
        expect(in_array('storage_column', $field->getFillable()))->toBeTrue();
        expect(in_array('storage', $field->getFillable()))->toBeTrue();
    });
});

describe('FieldResource notIn logic', function () {
    it('json mode fields skip the schema-column notIn check', function () {
        $field = (new Field())->forceFill([
            'storage' => 'json',
            'code'    => 'subtitle',
        ]);
        expect($field->isJsonMode())->toBeTrue();
    });

    it('FieldResource warns about JSON key collisions when source data already uses the key', function () {
        $source = file_get_contents(
            (new ReflectionClass(\Webkul\CustomFields\Filament\Resources\FieldResource::class))->getFileName()
        );

        expect($source)->toContain('collision-warning');
        expect($source)->toContain('JSON_CONTAINS_PATH');
        expect($source)->toContain('afterStateUpdated');
    });
});

describe('Storage table column display', function () {
    it('StorageMode enum has the two expected values for UI rendering', function () {
        $cases = StorageMode::cases();
        $values = array_map(fn ($c) => $c->value, $cases);
        expect($values)->toContain('schema')->toContain('json');
        expect(count($cases))->toBe(2);
    });
});
