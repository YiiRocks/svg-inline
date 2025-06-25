<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;
use Yiisoft\Yii\View\Renderer\LayoutParametersInjectionInterface;

final class SvgInjections implements CommonParametersInjectionInterface, LayoutParametersInjectionInterface
{
    private SvgInlineInterface $svg;

    public function __construct(
        SvgInlineInterface $svg
    ) {
        $this->svg = $svg;
    }

    #[\Override]
    public function getCommonParameters(): array
    {
        return [
            'svg' => $this->svg,
        ];
    }

    #[\Override]
    public function getLayoutParameters(): array
    {
        return [
            'svg' => $this->svg,
        ];
    }
}
