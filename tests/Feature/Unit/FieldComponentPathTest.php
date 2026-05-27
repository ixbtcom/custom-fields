<?php

use Webkul\CustomFields\Enums\StorageMode;
use Webkul\CustomFields\Filament\Forms\Components\CustomFields;
use Webkul\CustomFields\Filament\Infolists\Components\CustomEntries;
use Webkul\CustomFields\Filament\Tables\Columns\CustomColumns;
use Webkul\CustomFields\Models\Field;

describe('getComponentPath for form/column/entry naming', function () {
    it('returns code for schema-mode field', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Schema->value,
            'code'           => 'my_score',
            'storage_column' => null,
        ]);

        expect($field->getComponentPath())->toBe('my_score');
    });

    it('returns column.code for json-mode field', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'code'           => 'my_score',
            'storage_column' => 'extra',
        ]);

        expect($field->getComponentPath())->toBe('extra.my_score');
    });

    it('falls back to extra.code when storage_column is null in json mode', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'code'           => 'my_score',
            'storage_column' => null,
        ]);

        expect($field->getComponentPath())->toBe('extra.my_score');
    });

    it('getQueryColumn for json mode returns arrow notation', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'code'           => 'rating',
            'storage_column' => 'metadata',
        ]);

        expect($field->getQueryColumn())->toBe('metadata->rating');
    });

    it('getSanitizedName avoids arrow in constraint name for json mode', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'code'           => 'rating',
            'storage_column' => 'extra',
        ]);

        $sanitized = $field->getSanitizedName();
        expect($sanitized)->toBe('extra_rating');
        expect($sanitized)->not->toContain('->');
        expect($sanitized)->not->toContain('.');
    });
});

describe('CustomFields/CustomColumns/CustomEntries class existence', function () {
    it('CustomFields, CustomColumns, CustomEntries classes exist', function () {
        expect(class_exists(CustomFields::class))->toBeTrue();
        expect(class_exists(CustomColumns::class))->toBeTrue();
        expect(class_exists(CustomEntries::class))->toBeTrue();
    });

    it('createField method uses getComponentPath (reflection check)', function () {
        $source = file_get_contents(
            (new ReflectionClass(CustomFields::class))->getFileName()
        );
        expect($source)->toContain('getComponentPath');
    });

    it('createColumn method uses getComponentPath (reflection check)', function () {
        $source = file_get_contents(
            (new ReflectionClass(CustomColumns::class))->getFileName()
        );
        expect($source)->toContain('getComponentPath');
    });

    it('createEntry method uses getComponentPath (reflection check)', function () {
        $source = file_get_contents(
            (new ReflectionClass(CustomEntries::class))->getFileName()
        );
        expect($source)->toContain('getComponentPath');
    });
});
