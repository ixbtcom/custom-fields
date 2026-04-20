<?php

namespace Webkul\CustomFields\Concerns;

use Exception;
use Webkul\CustomFields\Models\Field;

trait HasCustomFields
{
    protected static mixed $customFillable;

    protected static mixed $customCasts;

    protected static function bootHasCustomFields()
    {
        static::retrieved(fn ($model) => $model->loadCustomFields());

        static::creating(fn ($model) => $model->loadCustomFields());

        static::updating(fn ($model) => $model->loadCustomFields());
    }

    public function fill(array $attributes): static
    {
        $this->loadCustomFields();

        return parent::fill($attributes);
    }

    protected function loadCustomFields()
    {
        try {
            $customFields = $this->getCustomFields();

            $this->mergeFillable(self::$customFillable ??= $customFields->pluck('code')->toArray());

            $this->mergeCasts(self::$customCasts ??= $customFields->select('code', 'type', 'is_multiselect')->get());
        } catch (Exception $e) {
        }
    }

    protected function getCustomFields()
    {
        return Field::where('customizable_type', get_class($this));
    }

    public function mergeFillable(array $attributes): void
    {
        $this->fillable = array_unique(array_merge($this->fillable, $attributes));
    }

    public function mergeCasts($attributes)
    {
        if (is_array($attributes)) {
            parent::mergeCasts($attributes);

            return $attributes;
        }

        foreach ($attributes as $attribute) {
            match ($attribute->type) {
                'select'        => $this->casts[$attribute->code] = $attribute->is_multiselect ? 'array' : 'string',
                'checkbox'      => $this->casts[$attribute->code] = 'boolean',
                'toggle'        => $this->casts[$attribute->code] = 'boolean',
                'checkbox_list' => $this->casts[$attribute->code] = 'array',
                default         => $this->casts[$attribute->code] = 'string',
            };
        }

        return $this;
    }
}
