<?php

namespace Webkul\CustomFields\Enums;

enum InputType: string
{
    case Text = 'text';
    case Email = 'email';
    case Numeric = 'numeric';
    case Integer = 'integer';
    case Password = 'password';
    case Tel = 'tel';
    case Url = 'url';
    case Color = 'color';

    public static function default(): self
    {
        return self::Text;
    }
}
