<?php

namespace Webkul\CustomFields\Enums;

enum FieldType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Select = 'select';
    case Checkbox = 'checkbox';
    case Radio = 'radio';
    case Toggle = 'toggle';
    case CheckboxList = 'checkbox_list';
    case DateTime = 'datetime';
    case Editor = 'editor';
    case Markdown = 'markdown';
    case ColorPicker = 'color';

    public static function default(): self
    {
        return self::Text;
    }
}
