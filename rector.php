<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Yiisoft\CodeStyle\Rector\Rules\RemoveOverrideAttributeRector;
use Yiisoft\CodeStyle\Rector\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/config',
    ])
    ->withPhpSets(php83: true)
    ->withSets([
        SetList::YII_CORE,
    ])
    ->withSkip([
        AddOverrideAttributeToOverriddenMethodsRector::class => [__DIR__ . '/tests'],
        RemoveOverrideAttributeRector::class => [
            __DIR__ . '/src',
            __DIR__ . '/config',
        ],
    ]);
