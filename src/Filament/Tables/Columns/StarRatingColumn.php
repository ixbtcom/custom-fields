<?php

namespace Webkul\CustomFields\Filament\Tables\Columns;

use Closure;
use Filament\Tables\Columns\Column;

class StarRatingColumn extends Column
{
    protected string $view = 'custom-fields::filament.tables.columns.star-rating-column';

    protected int | Closure $base = 100;

    protected float | Closure $maxValue = 10.0;

    protected int | Closure $starCount = 5;

    public function getDisplayValue(): ?float
    {
        $state = $this->getState();

        if ($state === null || $state === '') {
            return null;
        }

        $base = $this->getBase();

        if ($base <= 0) {
            return (float) $state;
        }

        return round(((int) $state) / $base, 2);
    }

    public function base(int | Closure $base): static
    {
        $this->base = $base;

        return $this;
    }

    public function maxValue(float | Closure $maxValue): static
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    public function starCount(int | Closure $starCount): static
    {
        $this->starCount = $starCount;

        return $this;
    }

    public function getBase(): int
    {
        return max(1, (int) $this->evaluate($this->base));
    }

    public function getMaxValue(): float
    {
        return (float) $this->evaluate($this->maxValue);
    }

    public function getStarCount(): int
    {
        return max(1, (int) $this->evaluate($this->starCount));
    }

    public function getPointsPerStar(): float
    {
        $stars = $this->getStarCount();

        if ($stars <= 0) {
            return $this->getMaxValue();
        }

        return $this->getMaxValue() / $stars;
    }
}
