<?php

declare(strict_types=1);

use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;

/* @var array $params */

return [
    SvgInlineInterface::class => [
        '__class' => SvgInline::class,
        'setFallbackIcon()' => [$params['yiirocks/svg-inline']['fallbackIcon']],
        'setFill()' => [$params['yiirocks/svg-inline']['fill']],
    ],
];
