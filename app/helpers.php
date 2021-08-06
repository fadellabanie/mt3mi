<?php

use Illuminate\Support\HtmlString;

if (! function_exists('svg')) {
    function svg($filename)
    {
        return new HtmlString(
            file_get_contents(resource_path("svg/{$filename}.svg"))
        );
    }
}

function formatBytes($size, $precision = 2)
{
    $base = log((float) $size, 1024);
    $suffixes = ['', 'K', 'M', 'G', 'T'];

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}