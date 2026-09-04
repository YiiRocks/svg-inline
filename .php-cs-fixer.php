<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use Yiisoft\CodeStyle\ConfigBuilder;

$finder = (new Finder())->in(__DIR__);

return ConfigBuilder::build()
    ->setUsingCache(false)
    ->setRules([
        '@Yiisoft/Core' => true,
    ])
    ->setFinder($finder);
