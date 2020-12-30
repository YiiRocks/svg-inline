<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

use Yiisoft\Yii\View\ContentParametersInjectionInterface;
use Yiisoft\Yii\View\LayoutParametersInjectionInterface;

final class UserViewInjection implements ContentParametersInjectionInterface, LayoutParametersInjectionInterface
{
    private SvgInlineInterface $svg;

    public function __construct(
        SvgInlineInterface $svg
    ) {
        $this->svg = $svg;
    }

    public function getContentParameters(): array
    {
        return [
            'svg' => $this->svg,
        ];
    }

    public function getLayoutParameters(): array
    {
        return [
            'svg' => $this->svg,
        ];
    }
}
