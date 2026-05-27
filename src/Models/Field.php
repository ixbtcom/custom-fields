<?php

namespace Webkul\CustomFields\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Webkul\CustomFields\Enums\StorageMode;

class Field extends Model implements Sortable
{
    use SoftDeletes, SortableTrait;

    protected $table = 'custom_fields';

    protected $casts = [
        'is_multiselect'    => 'boolean',
        'options'           => 'array',
        'form_settings'     => 'array',
        'table_settings'    => 'array',
        'infolist_settings' => 'array',
        'storage'           => StorageMode::class,
    ];

    protected $fillable = [
        'code',
        'name',
        'type',
        'input_type',
        'is_multiselect',
        'datalist',
        'options',
        'form_settings',
        'use_in_table',
        'table_settings',
        'infolist_settings',
        'sort',
        'customizable_type',
        'storage',
        'storage_column',
    ];

    public $sortable = [
        'order_column_name'  => 'sort',
        'sort_when_creating' => true,
    ];

    public function isJsonMode(): bool
    {
        return $this->storage === StorageMode::Json;
    }

    public function isSchemaMode(): bool
    {
        return ! $this->isJsonMode();
    }

    public function getJsonColumn(): string
    {
        return $this->storage_column ?: 'extra';
    }

    public function getComponentPath(): string
    {
        if ($this->isJsonMode()) {
            return $this->getJsonColumn() . '.' . $this->code;
        }

        return $this->code;
    }

    public function getQueryColumn(): string
    {
        if ($this->isJsonMode()) {
            return $this->getJsonColumn() . '->' . $this->code;
        }

        return $this->code;
    }

    public function getSanitizedName(): string
    {
        if ($this->isJsonMode()) {
            return $this->getJsonColumn() . '_' . $this->code;
        }

        return $this->code;
    }
}
