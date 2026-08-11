<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

use Override;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;
use Yiisoft\Yii\View\Renderer\LayoutParametersInjectionInterface;

final class SvgInjections implements CommonParametersInjectionInterface, LayoutParametersInjectionInterface
{
    public function __construct(private SvgInlineInterface $svg) {}

    #[Override]
    public function getCommonParameters(): array
    {
        return [
            'svg' => $this->svg,
        ];
    }

    #[Override]
    public function getLayoutParameters(): array
    {
        return [
            'svg' => $this->svg,
        ];
    }
}
