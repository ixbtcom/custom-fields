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
        $qCol = $field->getQueryColumn();
        $name = $field->getSanitizedName();

        $filter = match ($field->type) {
            'checkbox' => Filter::make($name)
                ->query(fn (Builder $query): Builder => $query->where($qCol, true)),

            'toggle' => Filter::make($name)
                ->toggle()
                ->query(fn (Builder $query): Builder => $query->where($qCol, true)),

            'radio' => SelectFilter::make($name)
                ->attribute($qCol)
                ->options(function () use ($field) {
                    return collect($field->options)
                        ->mapWithKeys(fn ($option) => [$option => $option])
                        ->toArray();
                }),

            'select' => $field->is_multiselect
                ? SelectFilter::make($name)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    })
                    ->query(function (Builder $query, $state) use ($qCol): Builder {
                        if (empty($state['values'])) {
                            return $query;
                        }

                        return $query->where(function (Builder $query) use ($state, $qCol) {
                            foreach ((array) $state['values'] as $value) {
                                $query->orWhereJsonContains($qCol, $value);
                            }
                        });
                    })
                    ->multiple()
                : SelectFilter::make($name)
                    ->attribute($qCol)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    }),

            'checkbox_list' => SelectFilter::make($name)
                ->options(function () use ($field) {
                    return collect($field->options)
                        ->mapWithKeys(fn ($option) => [$option => $option])
                        ->toArray();
                })
                ->query(function (Builder $query, $state) use ($qCol): Builder {
                    if (empty($state['values'])) {
                        return $query;
                    }

                    return $query->where(function (Builder $query) use ($state, $qCol) {
                        foreach ((array) $state['values'] as $value) {
                            $query->orWhereJsonContains($qCol, $value);
                        }
                    });
                })
                ->multiple(),

            'star_rating' => Filter::make($name)
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
                ->query(function (Builder $query, array $data) use ($field, $qCol): Builder {
                    $base    = StarRating::DEFAULT_BASE;
                    $isJson  = $field->isJsonMode();

                    return $query
                        ->when(
                            isset($data['from']) && $data['from'] !== '' && $data['from'] !== null,
                            function (Builder $q) use ($qCol, $data, $base, $isJson) {
                                $val = (int) round(((float) $data['from']) * $base);
                                $isJson
                                    ? $this->applyJsonIntegerComparison($q, $qCol, '>=', $val)
                                    : $q->where($qCol, '>=', $val);
                            }
                        )
                        ->when(
                            isset($data['to']) && $data['to'] !== '' && $data['to'] !== null,
                            function (Builder $q) use ($qCol, $data, $base, $isJson) {
                                $val = (int) round(((float) $data['to']) * $base);
                                $isJson
                                    ? $this->applyJsonIntegerComparison($q, $qCol, '<=', $val)
                                    : $q->where($qCol, '<=', $val);
                            }
                        );
                }),

            default => Filter::make($name)->query(fn (Builder $q): Builder => $q),
        };

        return $filter->label($field->name);
    }

    protected function extractJsonColumn(string $queryColumn): string
    {
        return explode('->', $queryColumn, 2)[0];
    }

    protected function extractJsonKey(string $queryColumn): string
    {
        return explode('->', $queryColumn, 2)[1] ?? $queryColumn;
    }

    protected function applyJsonIntegerComparison(Builder $query, string $queryColumn, string $operator, int $value): Builder
    {
        $column = $this->extractJsonColumn($queryColumn);
        $key = $this->extractJsonKey($queryColumn);

        if (! $this->isSqlIdentifier($column) || ! $this->isSqlIdentifier($key)) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereRaw(
            "CAST(JSON_UNQUOTE(JSON_EXTRACT(`{$query->getModel()->getTable()}`.`{$column}`, ?)) AS SIGNED) {$operator} ?",
            ['$.' . $key, $value],
        );
    }

    protected function isSqlIdentifier(string $value): bool
    {
        return (bool) preg_match('/^[a-z_][a-z0-9_]*$/i', $value);
    }

    protected function createConstraint(Field $field): Constraint
    {
        $qCol = $field->getQueryColumn();
        $name = $field->getSanitizedName();

        $filter = match ($field->type) {
            'text' => match ($field->input_type) {
                'integer' => NumberConstraint::make($name)->attribute($qCol)->integer(),
                'numeric' => NumberConstraint::make($name)->attribute($qCol),
                default   => TextConstraint::make($name)->attribute($qCol),
            },

            'datetime' => DateConstraint::make($name)->attribute($qCol),

            'checkbox', 'toggle' => BooleanConstraint::make($name)->attribute($qCol),

            'select' => $field->is_multiselect
                ? SelectConstraint::make($name)
                    ->attribute($qCol)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    })
                    ->multiple()
                : SelectConstraint::make($name)
                    ->attribute($qCol)
                    ->options(function () use ($field) {
                        return collect($field->options)
                            ->mapWithKeys(fn ($option) => [$option => $option])
                            ->toArray();
                    }),

            'checkbox_list' => SelectConstraint::make($name)
                ->attribute($qCol)
                ->options(function () use ($field) {
                    return collect($field->options)
                        ->mapWithKeys(fn ($option) => [$option => $option])
                        ->toArray();
                })
                ->multiple(),

            'star_rating' => StarRatingConstraint::make($field->getSanitizedName())
                ->attribute($field->getQueryColumn())
                ->integer(),

            default => TextConstraint::make($name)->attribute($qCol),
        };

        return $filter->label($field->name);
    }
}
