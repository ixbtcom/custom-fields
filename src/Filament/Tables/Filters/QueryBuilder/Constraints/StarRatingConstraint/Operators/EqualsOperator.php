<?php

namespace Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators;

use Filament\QueryBuilder\Constraints\NumberConstraint\Operators\EqualsOperator as BaseEqualsOperator;
use Illuminate\Database\Eloquent\Builder;

class EqualsOperator extends BaseEqualsOperator
{
    public function apply(Builder $query, string $qualifiedColumn): Builder
    {
        $base = $this->getConstraint()->getBase();
        $value = (int) round(floatval($this->getSettings()['number']) * $base);

        if (filled($this->getAggregate())) {
            $operator = $this->isInverse() ? '!=' : '=';

            return $this->applyAggregateComparison($query, $operator, $value);
        }

        return $query->where($qualifiedColumn, $this->isInverse() ? '!=' : '=', $value);
    }
}
