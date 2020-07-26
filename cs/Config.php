<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline\cs;

/**
 * Basic rules.
 */
class Config extends \PhpCsFixer\Config
{
    /**
     * Construct.
     *
     * @param mixed $name
     */
    public function __construct($name = 'yiirocks-cs-config')
    {
        parent::__construct($name);

        $this->setRiskyAllowed(true);

        $this->setRules([
            '@PSR1' => true,
            '@PSR2' => true,
            'no_unused_imports' => true,
            'ordered_class_elements' => [
                'sortAlgorithm' => 'alpha',
            ],
            'ordered_imports' => [
                'sortAlgorithm' => 'alpha',
            ],
        ]);
    }
}
