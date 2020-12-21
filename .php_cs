<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'ordered_class_elements' => [
            'sort_algorithm' => 'alpha',
        ],
        'no_unused_imports' => true,
        'ordered_imports' => [
            'imports_order' => [
                'const', 'class', 'function',
            ],
            'sort_algorithm' => 'alpha',
        ],
    ])
    ->setFinder($finder)
;
