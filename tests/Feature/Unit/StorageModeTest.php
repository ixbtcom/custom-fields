<?php

use Webkul\CustomFields\Enums\StorageMode;
use Webkul\CustomFields\Models\Field;

describe('StorageMode enum', function () {
    it('has Schema and Json cases with correct string values', function () {
        expect(StorageMode::Schema->value)->toBe('schema');
        expect(StorageMode::Json->value)->toBe('json');
    });

    it('can be iterated via cases()', function () {
        $values = array_map(fn ($c) => $c->value, StorageMode::cases());
        expect($values)->toContain('schema')->toContain('json');
    });
});

describe('Field storage helpers', function () {
    it('isSchemaMode() returns true by default', function () {
        $field = (new Field())->forceFill(['storage' => 'schema', 'code' => 'rating', 'storage_column' => null]);
        expect($field->isSchemaMode())->toBeTrue();
        expect($field->isJsonMode())->toBeFalse();
    });

    it('isJsonMode() returns true when storage is json', function () {
        $field = (new Field())->forceFill(['storage' => 'json', 'code' => 'rating', 'storage_column' => 'extra']);
        expect($field->isJsonMode())->toBeTrue();
        expect($field->isSchemaMode())->toBeFalse();
    });

    it('getComponentPath() returns code for schema mode', function () {
        $field = (new Field())->forceFill(['storage' => 'schema', 'code' => 'my_field', 'storage_column' => null]);
        expect($field->getComponentPath())->toBe('my_field');
    });

    it('getComponentPath() returns column.code for json mode', function () {
        $field = (new Field())->forceFill(['storage' => 'json', 'code' => 'my_field', 'storage_column' => 'extra']);
        expect($field->getComponentPath())->toBe('extra.my_field');
    });

    it('getComponentPath() falls back to "extra" when storage_column is null in json mode', function () {
        $field = (new Field())->forceFill(['storage' => 'json', 'code' => 'my_field', 'storage_column' => null]);
        expect($field->getComponentPath())->toBe('extra.my_field');
    });

    it('getQueryColumn() returns code for schema mode', function () {
        $field = (new Field())->forceFill(['storage' => 'schema', 'code' => 'score', 'storage_column' => null]);
        expect($field->getQueryColumn())->toBe('score');
    });

    it('getQueryColumn() returns column->code for json mode', function () {
        $field = (new Field())->forceFill(['storage' => 'json', 'code' => 'score', 'storage_column' => 'extra']);
        expect($field->getQueryColumn())->toBe('extra->score');
    });

    it('getQueryColumn() falls back to "extra->code" when storage_column is null', function () {
        $field = (new Field())->forceFill(['storage' => 'json', 'code' => 'score', 'storage_column' => null]);
        expect($field->getQueryColumn())->toBe('extra->score');
    });

    it('getJsonColumn() returns storage_column or "extra" fallback in json mode', function () {
        $jsonField = (new Field())->forceFill(['storage' => 'json', 'code' => 'x', 'storage_column' => 'metadata']);
        expect($jsonField->getJsonColumn())->toBe('metadata');

        $nullCol = (new Field())->forceFill(['storage' => 'json', 'code' => 'x', 'storage_column' => null]);
        expect($nullCol->getJsonColumn())->toBe('extra');
    });

    it('getSanitizedName() returns code for schema, column_code for json', function () {
        $schema = (new Field())->forceFill(['storage' => 'schema', 'code' => 'score', 'storage_column' => null]);
        expect($schema->getSanitizedName())->toBe('score');

        $json = (new Field())->forceFill(['storage' => 'json', 'code' => 'score', 'storage_column' => 'extra']);
        expect($json->getSanitizedName())->toBe('extra_score');
    });
});
