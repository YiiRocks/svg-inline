<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

/*
 * @method class(string $value): self
 * @method css(array $value): self
 * @method fill(string $value): self
 * @method fixedWidth(bool $value): self
 * @method height(int $value): self
 * @method id(string $value): self
 * @method name(string $value): self
 * @method title(string $value): self
 * @method width(int $value): self
 */
interface SvgInlineInterface
{
    public function __call(string $name, array $value): self;
    public function bootstrap(string $name): self;
    public function fai(string $name, ?string $style = null): self;
    public function file(string $file): self;
}
