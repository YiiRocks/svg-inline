<?php

declare(strict_types=1);

use YiiRocks\SvgInline\SvgInjections;
use YiiRocks\SvgInline\SvgInlineInterface;
use Yiisoft\Definitions\Reference;

return [
    'yiirocks/svg-inline' => [
        'fallbackIcon' => '@vendor/yiirocks/svg-inline/src/fallbackIcon.svg',
        'fill' => 'currentColor',
        // Extension packages (e.g. yiirocks/svg-inline-bootstrap) register themselves here,
        // mapping the `$svg->{key}()` method name to their IconSetInterface service id.
        'iconSets' => [],
    ],

    'yiisoft/view' => [
        'parameters' => [
            'svg' => Reference::to(SvgInlineInterface::class),
        ],
    ],

    'yiisoft/yii-view-renderer' => [
        'injections' => [
            Reference::to(SvgInjections::class),
        ],
    ],
];
