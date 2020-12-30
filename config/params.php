<?php

declare(strict_types=1);

use YiiRocks\SvgInline\SvgViewInjection;
use Yiisoft\Factory\Definitions\Reference;

return [
    'yiirocks/svg-inline' => [
        'fallbackIcon' => '@vendor/yiirocks/svg-inline/src/fallbackIcon.svg',
        'fill' => 'currentColor',
    ],

    'yiisoft/yii-view' => [
        'injections' => [
            Reference::to(SvgViewInjection::class),
        ],
    ],
];
