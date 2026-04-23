<?php

use Webkul\CustomFields\Filament\Forms\Components\CustomFields;
use Webkul\CustomFields\Filament\Infolists\Components\CustomEntries;
use Webkul\CustomFields\Filament\Tables\Columns\CustomColumns;
use Webkul\CustomFields\Filament\Tables\Filters\CustomFilters;

$makeStub = fn () => new class {
    public static function getModel(): string
    {
        return 'App\\Models\\Stub';
    }
};

it('CustomFields::make returns a configured instance', function () use ($makeStub) {
    $stub = $makeStub();

    $component = CustomFields::make($stub::class);

    expect($component)->toBeInstanceOf(CustomFields::class);
    expect($component->include(['a']))->toBe($component);
    expect($component->exclude(['b']))->toBe($component);
});

it('CustomEntries::make returns a configured instance', function () use ($makeStub) {
    $stub = $makeStub();

    $component = CustomEntries::make($stub::class);

    expect($component)->toBeInstanceOf(CustomEntries::class);
    expect($component->include(['a']))->toBe($component);
    expect($component->exclude(['b']))->toBe($component);
});

it('CustomColumns::make returns a configured instance', function () use ($makeStub) {
    $stub = $makeStub();

    $component = CustomColumns::make($stub::class);

    expect($component)->toBeInstanceOf(CustomColumns::class);
    expect($component->include(['a']))->toBe($component);
    expect($component->exclude(['b']))->toBe($component);
});

it('CustomFilters::make returns a configured instance', function () use ($makeStub) {
    $stub = $makeStub();

    $component = CustomFilters::make($stub::class);

    expect($component)->toBeInstanceOf(CustomFilters::class);
    expect($component->include(['a']))->toBe($component);
    expect($component->exclude(['b']))->toBe($component);
});

it('all four injector classes publicly expose getSchema or getColumns or getFilters', function () {
    expect(method_exists(CustomFields::class, 'getSchema'))->toBeTrue();
    expect(method_exists(CustomEntries::class, 'getSchema'))->toBeTrue();
    expect(method_exists(CustomColumns::class, 'getColumns'))->toBeTrue();
    expect(method_exists(CustomFilters::class, 'getFilters'))->toBeTrue();
    expect(method_exists(CustomFilters::class, 'getQueryBuilderConstraints'))->toBeTrue();
});

it('StarRating component classes exist and extend the expected base classes', function () {
    expect(class_exists(\Webkul\CustomFields\Filament\Forms\Components\StarRating::class))->toBeTrue();
    expect(class_exists(\Webkul\CustomFields\Filament\Infolists\Components\StarRatingEntry::class))->toBeTrue();
    expect(class_exists(\Webkul\CustomFields\Filament\Tables\Columns\StarRatingColumn::class))->toBeTrue();

    expect(is_subclass_of(
        \Webkul\CustomFields\Filament\Forms\Components\StarRating::class,
        \Filament\Forms\Components\Field::class,
    ))->toBeTrue();

    expect(is_subclass_of(
        \Webkul\CustomFields\Filament\Infolists\Components\StarRatingEntry::class,
        \Filament\Infolists\Components\Entry::class,
    ))->toBeTrue();

    expect(is_subclass_of(
        \Webkul\CustomFields\Filament\Tables\Columns\StarRatingColumn::class,
        \Filament\Tables\Columns\Column::class,
    ))->toBeTrue();
});
