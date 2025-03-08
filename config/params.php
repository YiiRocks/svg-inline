<?php

declare(strict_types=1);

use YiiRocks\SvgInline\SvgViewInjection;
use Yiisoft\Definitions\Reference;

return [
    'yiirocks/svg-inline' => [
        'fallbackIcon' => '@vendor/yiirocks/svg-inline/src/fallbackIcon.svg',
        'fill' => 'currentColor',
    ],

    'yiisoft/yii-view-renderer' => [
        'viewPath' => null,
        'layout' => null,
        'injections' => [
            Reference::to(SvgViewInjection::class),
        ],
    ],
];
