<?php

namespace Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints;

use Filament\QueryBuilder\Constraints\Operators\IsFilledOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Webkul\CustomFields\Filament\Forms\Components\StarRating;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\EqualsOperator;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\IsMaxOperator;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\IsMinOperator;

class StarRatingConstraint extends NumberConstraint
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->operators([
            IsMinOperator::class,
            IsMaxOperator::class,
            EqualsOperator::class,
            IsFilledOperator::make()
                ->visible(fn (): bool => $this->isNullable()),
        ]);
    }

    public function getBase(): int
    {
        return StarRating::DEFAULT_BASE;
    }
}
