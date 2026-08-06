<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use Yiisoft\CodeStyle\ConfigBuilder;

$finder = (new Finder())->in(__DIR__);

return ConfigBuilder::build()
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setRules([
        '@Yiisoft/Core' => true,
        '@PER-CS3.0' => true,
        'ordered_class_elements' => [
            'sort_algorithm' => 'alpha',
        ],
        'ordered_imports' => [
            'imports_order' => [
                'const', 'class', 'function',
            ],
            'sort_algorithm' => 'alpha',
        ],
    ])
    ->setFinder($finder);
