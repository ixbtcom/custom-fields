<?php

/**
 * Deep key-parity assertion between `en` and `ru` translation files.
 * A missing or extra key (at any nesting level) fails the test.
 */

function cfDiffTranslationKeys(array $a, array $b, string $path = ''): array
{
    $diffs = [];

    foreach ($a as $k => $v) {
        $p = $path === '' ? (string) $k : "$path.$k";

        if (! array_key_exists($k, $b)) {
            $diffs[] = "MISSING IN TARGET: $p";

            continue;
        }

        if (is_array($v) && is_array($b[$k])) {
            $diffs = array_merge($diffs, cfDiffTranslationKeys($v, $b[$k], $p));
        } elseif (is_array($v) !== is_array($b[$k])) {
            $diffs[] = "TYPE MISMATCH: $p";
        }
    }

    foreach ($b as $k => $v) {
        $p = $path === '' ? (string) $k : "$path.$k";

        if (! array_key_exists($k, $a)) {
            $diffs[] = "EXTRA IN TARGET: $p";
        }
    }

    return $diffs;
}

it('ru/field.php has full key parity with en/field.php', function () {
    $base = __DIR__.'/../../../resources/lang';

    $en = require $base.'/en/filament/resources/field.php';
    $ru = require $base.'/ru/filament/resources/field.php';

    $diffs = cfDiffTranslationKeys($en, $ru);

    expect($diffs)->toBe([], implode("\n", $diffs));
});

it('ru page files exist and expose the same top-level keys as en', function () {
    $base = __DIR__.'/../../../resources/lang';
    $pages = ['list-fields', 'edit-field', 'create-field'];

    foreach ($pages as $page) {
        $en = require $base."/en/filament/resources/field/pages/$page.php";
        $ru = require $base."/ru/filament/resources/field/pages/$page.php";

        $diffs = cfDiffTranslationKeys($en, $ru);
        expect($diffs)->toBe([], "Page $page diffs: ".implode("\n", $diffs));
    }
});
