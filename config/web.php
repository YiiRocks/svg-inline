<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;
use Yiisoft\Aliases\Aliases;

/* @var array $params */

return [
    SvgInlineInterface::class => static function (ContainerInterface $container) use ($params) {
        $svgInline = new SvgInline($container->get(Aliases::class), $container);
        $svgInline->setFallbackIcon($params['yiirocks/svg-inline']['fallbackIcon']);
        $svgInline->setFill($params['yiirocks/svg-inline']['fill']);

        return $svgInline;
    },
];
