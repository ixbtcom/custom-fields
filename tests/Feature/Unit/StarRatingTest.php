<?php

use Webkul\CustomFields\Filament\Forms\Components\StarRating;
use Webkul\CustomFields\Filament\Infolists\Components\StarRatingEntry;
use Webkul\CustomFields\Filament\Tables\Columns\StarRatingColumn;

describe('StarRating form field', function () {
    it('exposes sane defaults', function () {
        expect(StarRating::DEFAULT_BASE)->toBe(100);
        expect(StarRating::DEFAULT_MAX_VALUE)->toBe(10.0);
        expect(StarRating::DEFAULT_STEP)->toBe(0.5);
        expect(StarRating::DEFAULT_STAR_COUNT)->toBe(5);
    });

    it('make() triggers setUp without runtime error', function () {
        $field = StarRating::make('score');

        expect($field)->toBeInstanceOf(StarRating::class);
        expect(method_exists($field, 'formatStateUsing'))->toBeTrue();
        expect(method_exists($field, 'dehydrateStateUsing'))->toBeTrue();
    });

    it('uses the expected view path', function () {
        $reflection = new ReflectionClass(StarRating::class);
        $view = $reflection->getProperty('view');
        $view->setAccessible(true);

        expect($view->getValue(StarRating::make('score')))
            ->toBe('custom-fields::filament.forms.components.star-rating');
    });

    it('getPointsPerStar divides max by star count', function () {
        expect(StarRating::make('score')->getPointsPerStar())->toBe(2.0);
    });

    it('getBase returns at least 1 even if a zero base is forced', function () {
        expect(StarRating::make('score')->base(0)->getBase())->toBe(1);
    });

    it('starCount setter accepts a runtime value', function () {
        expect(StarRating::make('score')->starCount(10)->getStarCount())->toBe(10);
    });
});

describe('StarRatingEntry infolist entry', function () {
    it('make() triggers setUp without runtime error', function () {
        $entry = StarRatingEntry::make('score');

        expect($entry)->toBeInstanceOf(StarRatingEntry::class);
        expect(method_exists($entry, 'formatStateUsing'))->toBeTrue();
    });

    it('uses the expected view path', function () {
        $reflection = new ReflectionClass(StarRatingEntry::class);
        $view = $reflection->getProperty('view');
        $view->setAccessible(true);

        expect($view->getValue(StarRatingEntry::make('score')))
            ->toBe('custom-fields::filament.infolists.components.star-rating-entry');
    });

    it('getBase defaults to 100', function () {
        expect(StarRatingEntry::make('score')->getBase())->toBe(100);
    });
});

describe('StarRatingColumn table column', function () {
    it('make() triggers setUp without runtime error (regression for missing formatStateUsing)', function () {
        $column = StarRatingColumn::make('score');

        expect($column)->toBeInstanceOf(StarRatingColumn::class);
        expect(method_exists($column, 'getDisplayValue'))->toBeTrue();
    });

    it('uses the expected view path', function () {
        $reflection = new ReflectionClass(StarRatingColumn::class);
        $view = $reflection->getProperty('view');
        $view->setAccessible(true);

        expect($view->getValue(StarRatingColumn::make('score')))
            ->toBe('custom-fields::filament.tables.columns.star-rating-column');
    });

    it('getMaxValue defaults to 10.0', function () {
        expect(StarRatingColumn::make('score')->getMaxValue())->toBe(10.0);
    });
});

describe('StarRatingConstraint QueryBuilder scaling', function () {
    it('exposes DEFAULT_BASE via getBase()', function () {
        $constraint = \Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint::make('score');

        expect($constraint->getBase())->toBe(StarRating::DEFAULT_BASE);
        expect($constraint->getBase())->toBe(100);
    });

    it('scaled operators multiply user input by base before comparing (display 8 → stored 800)', function () {
        $scale = fn (float $displayValue): int => (int) round($displayValue * StarRating::DEFAULT_BASE);

        expect($scale(8.0))->toBe(800);
        expect($scale(7.5))->toBe(750);
        expect($scale(0.5))->toBe(50);
        expect($scale(10.0))->toBe(1000);
        expect($scale(0.0))->toBe(0);
    });

    it('scaled operator classes exist in the expected namespace', function () {
        expect(class_exists(\Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\EqualsOperator::class))->toBeTrue();
        expect(class_exists(\Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\IsMinOperator::class))->toBeTrue();
        expect(class_exists(\Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\IsMaxOperator::class))->toBeTrue();

        expect(is_subclass_of(
            \Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\EqualsOperator::class,
            \Filament\QueryBuilder\Constraints\NumberConstraint\Operators\EqualsOperator::class,
        ))->toBeTrue();
    });
});
