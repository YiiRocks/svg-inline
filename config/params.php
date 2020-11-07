<?php

declare(strict_types=1);

use YiiRocks\SvgInline\SvgInlineInterface;
use Yiisoft\Factory\Definitions\Reference;

return [
    'yiirocks/svg-inline' => [
        'fallbackIcon' => '@vendor/yiirocks/svg-inline/src/fallbackIcon.svg',
        'fill' => 'currentColor',
    ],

    'yiisoft/view' => [
        'defaultParameters' => [
            'svg' => Reference::to(SvgInlineInterface::class),
        ],
    ],
];
