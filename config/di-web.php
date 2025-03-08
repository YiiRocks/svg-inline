<?php

declare(strict_types=1);

use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;

/** @var array $params */

return [
    SvgInlineInterface::class => [
        'class' => SvgInline::class,
        '__construct()' => [
            'fallbackIcon' => [$params['yiirocks/svg-inline']['fallbackIcon']],
            'fill' => [$params['yiirocks/svg-inline']['fill']],
        ],
    ],
];
