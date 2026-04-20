<?php

use Webkul\CustomFields\Enums\FieldType;
use Webkul\CustomFields\Enums\InputType;

describe('FieldType', function () {
    it('has all 11 cases with expected string values', function () {
        expect(FieldType::Text->value)->toBe('text');
        expect(FieldType::Textarea->value)->toBe('textarea');
        expect(FieldType::Select->value)->toBe('select');
        expect(FieldType::Checkbox->value)->toBe('checkbox');
        expect(FieldType::Radio->value)->toBe('radio');
        expect(FieldType::Toggle->value)->toBe('toggle');
        expect(FieldType::CheckboxList->value)->toBe('checkbox_list');
        expect(FieldType::DateTime->value)->toBe('datetime');
        expect(FieldType::Editor->value)->toBe('editor');
        expect(FieldType::Markdown->value)->toBe('markdown');
        expect(FieldType::ColorPicker->value)->toBe('color');
    });

    it('provides a default()', function () {
        expect(FieldType::default())->toBe(FieldType::Text);
    });

    it('tryFrom returns null for unknown values', function () {
        expect(FieldType::tryFrom('unknown'))->toBeNull();
    });

    it('tryFrom resolves known values', function () {
        expect(FieldType::tryFrom('select'))->toBe(FieldType::Select);
    });
});

describe('InputType', function () {
    it('has all 8 cases with expected string values', function () {
        expect(InputType::Text->value)->toBe('text');
        expect(InputType::Email->value)->toBe('email');
        expect(InputType::Numeric->value)->toBe('numeric');
        expect(InputType::Integer->value)->toBe('integer');
        expect(InputType::Password->value)->toBe('password');
        expect(InputType::Tel->value)->toBe('tel');
        expect(InputType::Url->value)->toBe('url');
        expect(InputType::Color->value)->toBe('color');
    });

    it('provides a default()', function () {
        expect(InputType::default())->toBe(InputType::Text);
    });
});
