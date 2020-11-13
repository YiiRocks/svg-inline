<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

interface SvgInlineInterface
{
    public function bootstrap(string $name): SvgInlineInterface;
    public function fai(string $name, ?string $style = null): SvgInlineInterface;
    public function file(string $file): SvgInlineInterface;
}
