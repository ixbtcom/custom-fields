<?php

use Webkul\CustomFields\Enums\StorageMode;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\Concerns\ComparesJsonPaths;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\EqualsOperator;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\IsMinOperator;
use Webkul\CustomFields\Models\Field;

describe('CustomFilters SQL path routing', function () {
    it('getQueryColumn returns arrow notation for json-mode', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'code'           => 'score',
            'storage_column' => 'extra',
        ]);

        expect($field->getQueryColumn())->toBe('extra->score');
    });

    it('getQueryColumn returns bare code for schema-mode', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Schema->value,
            'code'           => 'score',
            'storage_column' => null,
        ]);

        expect($field->getQueryColumn())->toBe('score');
    });

    it('getSanitizedName does not contain arrow for json-mode', function () {
        $field = (new Field())->forceFill([
            'storage'        => StorageMode::Json->value,
            'code'           => 'score',
            'storage_column' => 'extra',
        ]);

        $name = $field->getSanitizedName();
        expect($name)->toBe('extra_score');
        expect($name)->not->toContain('->');
    });
});

describe('StarRating operators with json path', function () {
    it('EqualsOperator delegates json paths to the hardened comparison helper', function () {
        $source = file_get_contents(
            (new ReflectionClass(EqualsOperator::class))->getFileName()
        );
        expect($source)->toContain('str_contains');
        expect($source)->toContain('applyJsonPathComparison');
    });

    it('IsMinOperator delegates json paths to the hardened comparison helper', function () {
        $source = file_get_contents(
            (new ReflectionClass(IsMinOperator::class))->getFileName()
        );
        expect($source)->toContain('str_contains');
        expect($source)->toContain('applyJsonPathComparison');
    });

    it('json path helper validates identifiers and binds JSON paths', function () {
        $source = file_get_contents(
            (new ReflectionClass(ComparesJsonPaths::class))->getFileName()
        );

        expect($source)->toContain('CAST');
        expect($source)->toContain('isSqlIdentifier');
        expect($source)->toContain('JSON_EXTRACT');
        expect($source)->toContain('1 = 0');
    });

    it('CustomFilters creates StarRatingConstraint using getSanitizedName and getQueryColumn', function () {
        $source = file_get_contents(
            (new ReflectionClass(\Webkul\CustomFields\Filament\Tables\Filters\CustomFilters::class))->getFileName()
        );
        expect($source)->toContain('getSanitizedName');
        expect($source)->toContain('getQueryColumn');
    });
});

describe('CustomFilters source has explicit attribute/query for all filter types', function () {
    it('CustomFilters source uses getQueryColumn', function () {
        $source = file_get_contents(
            (new ReflectionClass(\Webkul\CustomFields\Filament\Tables\Filters\CustomFilters::class))->getFileName()
        );
        expect($source)->toContain('getQueryColumn');
    });

    it('CustomFilters source uses getSanitizedName', function () {
        $source = file_get_contents(
            (new ReflectionClass(\Webkul\CustomFields\Filament\Tables\Filters\CustomFilters::class))->getFileName()
        );
        expect($source)->toContain('getSanitizedName');
    });
});
