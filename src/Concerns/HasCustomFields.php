<?php

namespace Webkul\CustomFields\Concerns;

use Exception;
use Webkul\CustomFields\Enums\StorageMode;
use Webkul\CustomFields\Models\Field;

trait HasCustomFields
{
    protected static array $customFieldsCache = [];

    protected static function bootHasCustomFields(): void
    {
        static::retrieved(fn ($model) => $model->loadCustomFields());

        static::creating(fn ($model) => $model->loadCustomFields());

        static::updating(fn ($model) => $model->loadCustomFields());
    }

    public function fill(array $attributes): static
    {
        $this->loadCustomFields();

        $attributes = $this->mergeJsonStorageColumns($attributes);

        return parent::fill($attributes);
    }

    protected function mergeJsonStorageColumns(array $attributes): array
    {
        $jsonCols = static::resolveCustomFieldsCache()['json_columns'] ?? [];

        foreach ($jsonCols as $col) {
            if (array_key_exists($col, $attributes) && is_array($attributes[$col])) {
                $current = (array) ($this->getAttribute($col) ?? []);
                $attributes[$col] = array_replace_recursive($current, $attributes[$col]);
            }
        }

        return $attributes;
    }

    protected function loadCustomFields(): void
    {
        try {
            $cache = static::resolveCustomFieldsCache();

            $this->mergeFillable($cache['fillable']);
            $this->mergeCasts($cache['casts']);
        } catch (Exception) {
        }
    }

    protected static function resolveCustomFieldsCache(): array
    {
        $classKey = static::class;

        if (isset(static::$customFieldsCache[$classKey])) {
            return static::$customFieldsCache[$classKey];
        }

        try {
            $all = Field::withTrashed()
                ->where('customizable_type', $classKey)
                ->orderBy('id')
                ->get(['id', 'code', 'type', 'is_multiselect', 'storage', 'storage_column', 'updated_at']);

            $schema     = $all->filter(fn ($f) => $f->storage !== StorageMode::Json);
            $fillable   = $schema->pluck('code')->toArray();
            $castsData  = [];
            $jsonCols   = [];

            foreach ($schema as $attribute) {
                $castsData[$attribute->code] = match ($attribute->type) {
                    'select'        => $attribute->is_multiselect ? 'array' : 'string',
                    'checkbox'      => 'boolean',
                    'toggle'        => 'boolean',
                    'checkbox_list' => 'array',
                    'star_rating'   => 'integer',
                    default         => 'string',
                };
            }

            foreach ($all as $f) {
                if ($f->storage === StorageMode::Json) {
                    $col = $f->storage_column ?: 'extra';
                    $jsonCols[$col] = true;
                }
            }

            $result = [
                'fillable'    => $fillable,
                'casts'       => $castsData,
                'json_columns' => array_keys($jsonCols),
            ];

            static::$customFieldsCache[$classKey] = $result;

            return $result;
        } catch (Exception) {
            return ['fillable' => [], 'casts' => [], 'json_columns' => []];
        }
    }

    public static function flushCustomFieldsCache(): void
    {
        unset(static::$customFieldsCache[static::class]);
    }

    protected function getCustomFields()
    {
        return Field::where('customizable_type', get_class($this));
    }

    public function mergeFillable(array $attributes): void
    {
        $this->fillable = array_unique(array_merge($this->fillable, $attributes));
    }

    public function mergeCasts($attributes): static
    {
        if (is_array($attributes)) {
            parent::mergeCasts($attributes);

            return $this;
        }

        foreach ($attributes as $attribute) {
            match ($attribute->type) {
                'select'        => $this->casts[$attribute->code] = $attribute->is_multiselect ? 'array' : 'string',
                'checkbox'      => $this->casts[$attribute->code] = 'boolean',
                'toggle'        => $this->casts[$attribute->code] = 'boolean',
                'checkbox_list' => $this->casts[$attribute->code] = 'array',
                'star_rating'   => $this->casts[$attribute->code] = 'integer',
                default         => $this->casts[$attribute->code] = 'string',
            };
        }

        return $this;
    }
}
