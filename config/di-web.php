<?php

declare(strict_types=1);

use YiiRocks\SvgInline\Icon;
use YiiRocks\SvgInline\IconInterface;
use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;

/** @var array $params */

return [
    IconInterface::class => Icon::class,
    SvgInlineInterface::class => [
        'class' => SvgInline::class,
        'setFallbackIcon()' => [$params['yiirocks/svg-inline']['fallbackIcon']],
        'setFill()' => [$params['yiirocks/svg-inline']['fill']],
    ],
];
