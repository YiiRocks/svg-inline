<?php

use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;

return [
    SvgInlineInterface::class => [
        '__class' => SvgInline::class,
        'setFallbackIcon()' => [$params['yiirocks/svg-inline']['fallbackIcon']],
        'setFill()' => [$params['yiirocks/svg-inline']['fill']],
    ],
];
