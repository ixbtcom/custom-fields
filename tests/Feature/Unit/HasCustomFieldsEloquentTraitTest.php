<?php

use Illuminate\Database\Eloquent\Model;
use Webkul\CustomFields\Concerns\HasCustomFields;

it('trait exists at expected namespace', function () {
    expect(trait_exists(HasCustomFields::class))->toBeTrue();
});

it('host model can apply the trait without error', function () {
    $model = new class extends Model {
        use HasCustomFields;

        protected $table = 'custom_fields_trait_host_stub';
    };

    expect($model)->toBeInstanceOf(Model::class);
});

it('mergeFillable appends without duplicates', function () {
    $model = new class extends Model {
        use HasCustomFields;

        protected $fillable = ['name', 'email'];
    };

    $model->mergeFillable(['email', 'phone', 'nickname']);

    $fillable = $model->getFillable();

    expect($fillable)->toContain('name');
    expect($fillable)->toContain('email');
    expect($fillable)->toContain('phone');
    expect($fillable)->toContain('nickname');
    expect(array_count_values($fillable)['email'])->toBe(1);
});

it('trait declares boot + fill + merge helpers', function () {
    $methods = get_class_methods(new class extends Model {
        use HasCustomFields;
    });

    expect($methods)->toContain('fill');
    expect($methods)->toContain('mergeFillable');
    expect($methods)->toContain('mergeCasts');
});
