<?php

namespace Webkul\CustomFields\Filament\Tables\Filters\QueryBuilder\Constraints\StarRatingConstraint\Operators\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait ComparesJsonPaths
{
    protected function applyJsonPathComparison(Builder $query, string $qualifiedColumn, string $operator, int $value): Builder
    {
        [$column, $key] = explode('->', $qualifiedColumn, 2);

        $quotedColumn = $this->quoteJsonColumn($column);

        if ($quotedColumn === null || ! $this->isSqlIdentifier($key)) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereRaw(
            "CAST(JSON_UNQUOTE(JSON_EXTRACT({$quotedColumn}, ?)) AS SIGNED) {$operator} ?",
            ['$.' . $key, $value],
        );
    }

    protected function quoteJsonColumn(string $column): ?string
    {
        $parts = explode('.', $column);

        if (count($parts) > 2) {
            return null;
        }

        foreach ($parts as $part) {
            if (! $this->isSqlIdentifier($part)) {
                return null;
            }
        }

        return collect($parts)
            ->map(fn (string $part): string => "`{$part}`")
            ->implode('.');
    }

    protected function isSqlIdentifier(string $value): bool
    {
        return (bool) preg_match('/^[a-z_][a-z0-9_]*$/i', $value);
    }
}
