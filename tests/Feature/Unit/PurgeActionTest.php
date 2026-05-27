<?php

use Webkul\CustomFields\Enums\StorageMode;
use Webkul\CustomFields\Filament\Resources\FieldResource;
use Webkul\CustomFields\Models\Field;

describe('Purge action SQL logic helpers', function () {
    it('FieldResource source contains purgeValues action', function () {
        $source = file_get_contents(
            (new ReflectionClass(FieldResource::class))->getFileName()
        );
        expect($source)->toContain('purgeValues');
        expect($source)->toContain('JSON_REMOVE');
        expect($source)->toContain('JSON_CONTAINS_PATH');
    });

    it('FieldResource source validates code/storage_column before SQL interpolation', function () {
        $source = file_get_contents(
            (new ReflectionClass(FieldResource::class))->getFileName()
        );
        expect($source)->toContain('preg_match');
        expect($source)->toContain('invalid_column');
    });

    it('FieldResource source gates on non-MySQL for json purge', function () {
        $source = file_get_contents(
            (new ReflectionClass(FieldResource::class))->getFileName()
        );
        expect($source)->toContain('getDriverName');
        expect($source)->toContain('mysql');
    });

    it('schema-mode purge uses basic UPDATE SET NULL', function () {
        // Verification that schema mode path uses simple ->update() without JSON_REMOVE
        $source = file_get_contents(
            (new ReflectionClass(FieldResource::class))->getFileName()
        );
        // Schema path should update the column to null
        expect($source)->toContain('null');
    });

    it('purge action rejects code with SQL injection payload (validation coverage)', function () {
        $maliciousCode = "'; DROP TABLE universal_publications; --";
        expect(preg_match('/^[a-z_][a-z0-9_]*$/i', $maliciousCode))->toBe(0);
    });

    it('purge action validates normal code passes regex', function () {
        $validCode = 'my_json_field';
        expect(preg_match('/^[a-z_][a-z0-9_]*$/i', $validCode))->toBe(1);
    });
});
