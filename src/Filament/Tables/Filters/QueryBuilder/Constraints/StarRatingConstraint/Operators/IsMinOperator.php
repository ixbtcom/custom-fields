<?php

namespace Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators;

use Filament\QueryBuilder\Constraints\NumberConstraint\Operators\IsMinOperator as BaseIsMinOperator;
use Illuminate\Database\Eloquent\Builder;

class IsMinOperator extends BaseIsMinOperator
{
    public function apply(Builder $query, string $qualifiedColumn): Builder
    {
        $base = $this->getConstraint()->getBase();
        $value = (int) round(floatval($this->getSettings()['number']) * $base);

        if (filled($this->getAggregate())) {
            $operator = $this->isInverse() ? '<' : '>=';

            return $this->applyAggregateComparison($query, $operator, $value);
        }

        return $query->where($qualifiedColumn, $this->isInverse() ? '<' : '>=', $value);
    }
}
