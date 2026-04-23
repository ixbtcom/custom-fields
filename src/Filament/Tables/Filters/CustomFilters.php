<?php

namespace Webkul\CustomFields\Filament\Tables\Filters;

use Filament\Forms\Components\TextInput;
use Filament\Support\Components\Component;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\Constraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Webkul\CustomFields\Filament\Forms\Components\StarRating;
use Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint;
use Webkul\CustomFields\Models\Field;

class CustomFilters extends Component
{
    protected array $include = [];

    protected array $exclude = [];

    protected ?string $resourceClass = null;

    final public function __construct(string $resource)
    {
        $this->resourceClass = $resource;
    }

    public static function make(string $resource): static
    {
        $static = app(static::class, ['resource' => $resource]);

        $static->configure();

        return $static;
    }

    public function include(array $fields): static
    {
        $this->include = $fields;

        return $this;
    }

    public function exclude(array $fields): static
    {
        $this->exclude = $fields;

        return $this;
    }

    protected function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    public function getFilters(): array
    {
        $fields = $this->getFields();

        return $fields->map(function ($field) {
            return $this->createFilter($field);
        })->toArray();
    }

    public function getQueryBuilderConstraints(): array
    {
        $fields = $this->getFields();

        return $fields->map(function ($field) {
            return $this->createConstraint($field);
        })->toArray();
    }

    protected function getFields(): Collection
    {
        $query = Field::query()
            ->where('customizable_type', $this->getResourceClass()::getModel())
            ->where('use_in_table', true);

        if (! empty($this->include)) {
            $query->whereIn('code', $this->include);
        }

        if (! empty($this->exclude)) {
            $query->whereNotIn('code', $this->exclude);
        }

        return $query
            ->orderBy('sort')
            ->whereJsonContains('table_settings', ['setting' => 'filterable'])
            ->get();
    }

    protected function createFilter(Field $field): BaseFilter
    {
        $filter = match ($field->type) {
            'checkbox' => Filter::make($field->code)
                ->query(fn (Builder $query): Builder => $query->where($field->code, true)),

            'toggle' => Filter::make($field->code)
                ->toggle()
                ->query(fn (Builder $query): Builder => $query->where($field->code, true)),

            'radio' => SelectFilter::make($field->code)
                ->options(function () use ($field) {
                    return collect($field->options)
                        ->mapWithKeys(fn ($option) => [$option => $option])
                        ->toArray();
                }),

            'select' => $field->is_multiselect
                ? SelectFilter::make($field->code)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    })
                    ->query(function (Builder $query, $state) use ($field): Builder {
                        if (empty($state['values'])) {
                            return $query;
                        }

                        return $query->where(function (Builder $query) use ($state, $field) {
                            foreach ((array) $state as $value) {
                                $query->orWhereJsonContains($field->code, $value);
                            }
                        });
                    })
                    ->multiple()
                : SelectFilter::make($field->code)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    }),

            'checkbox_list' => SelectFilter::make($field->code)
                ->options(function () use ($field) {
                    return collect($field->options)
                        ->mapWithKeys(fn ($option) => [$option => $option])
                        ->toArray();
                })
                ->query(function (Builder $query, $state) use ($field): Builder {
                    if (empty($state['values'])) {
                        return $query;
                    }

                    return $query->where(function (Builder $query) use ($state, $field) {
                        foreach ((array) $state as $value) {
                            $query->orWhereJsonContains($field->code, $value);
                        }
                    });
                })
                ->multiple(),

            'star_rating' => Filter::make($field->code)
                ->schema([
                    TextInput::make('from')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(StarRating::DEFAULT_MAX_VALUE)
                        ->step(StarRating::DEFAULT_STEP),
                    TextInput::make('to')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(StarRating::DEFAULT_MAX_VALUE)
                        ->step(StarRating::DEFAULT_STEP),
                ])
                ->query(function (Builder $query, array $data) use ($field): Builder {
                    $base = StarRating::DEFAULT_BASE;

                    return $query
                        ->when(
                            isset($data['from']) && $data['from'] !== '' && $data['from'] !== null,
                            fn (Builder $q) => $q->where($field->code, '>=', (int) round(((float) $data['from']) * $base))
                        )
                        ->when(
                            isset($data['to']) && $data['to'] !== '' && $data['to'] !== null,
                            fn (Builder $q) => $q->where($field->code, '<=', (int) round(((float) $data['to']) * $base))
                        );
                }),

            default => Filter::make($field->code),
        };

        return $filter->label($field->name);
    }

    protected function createConstraint(Field $field): Constraint
    {
        $filter = match ($field->type) {
            'text' => match ($field->input_type) {
                'integer' => NumberConstraint::make($field->code)->integer(),
                'numeric' => NumberConstraint::make($field->code),
                default   => TextConstraint::make($field->code),
            },

            'datetime' => DateConstraint::make($field->code),

            'checkbox', 'toggle' => BooleanConstraint::make($field->code),

            'select' => $field->is_multiselect
                ? SelectConstraint::make($field->code)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    })
                    ->multiple()
                : SelectConstraint::make($field->code)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    }),

            'checkbox_list' => SelectConstraint::make($field->code)
                ->options(function () use ($field) {
                    return collect($field->options)
                        ->mapWithKeys(fn ($option) => [$option => $option])
                        ->toArray();
                })
                ->multiple(),

            'star_rating' => StarRatingConstraint::make($field->code)
                ->integer(),

            default => TextConstraint::make($field->code),
        };

        return $filter->label($field->name);
    }
}
