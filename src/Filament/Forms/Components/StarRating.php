<?php

namespace Webkul\CustomFields\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Concerns\CanBeReadOnly;
use Filament\Forms\Components\Field;

class StarRating extends Field
{
    use CanBeReadOnly;


    public const DEFAULT_BASE = 100;

    public const DEFAULT_MAX_VALUE = 10.0;

    public const DEFAULT_STEP = 0.5;

    public const DEFAULT_STAR_COUNT = 5;

    protected string $view = 'custom-fields::filament.forms.components.star-rating';

    protected int | Closure $base = self::DEFAULT_BASE;

    protected float | Closure $maxValue = self::DEFAULT_MAX_VALUE;

    protected float | Closure $step = self::DEFAULT_STEP;

    protected int | Closure $starCount = self::DEFAULT_STAR_COUNT;

    protected bool | Closure $isClearable = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(function ($state): ?float {
            if ($state === null || $state === '') {
                return null;
            }

            $base = $this->getBase();

            if ($base <= 0) {
                return (float) $state;
            }

            return round(((int) $state) / $base, 2);
        });

        $this->dehydrateStateUsing(function ($state): ?int {
            if ($state === null || $state === '') {
                return null;
            }

            $float = (float) $state;
            $max   = $this->getMaxValue();
            $step  = $this->getStep();

            if ($float < 0) {
                $float = 0.0;
            }

            if ($float > $max) {
                $float = $max;
            }

            if ($step > 0) {
                $float = round($float / $step) * $step;
            }

            return (int) round($float * $this->getBase());
        });

        $this->rules([
            'nullable',
            'numeric',
        ]);
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

    public function step(float | Closure $step): static
    {
        $this->step = $step;

        return $this;
    }

    public function starCount(int | Closure $starCount): static
    {
        $this->starCount = $starCount;

        return $this;
    }

    public function clearable(bool | Closure $condition = true): static
    {
        $this->isClearable = $condition;

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

    public function getStep(): float
    {
        return (float) $this->evaluate($this->step);
    }

    public function getStarCount(): int
    {
        return max(1, (int) $this->evaluate($this->starCount));
    }

    public function isClearable(): bool
    {
        return (bool) $this->evaluate($this->isClearable);
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
