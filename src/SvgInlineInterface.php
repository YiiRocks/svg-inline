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
 *
 * Icon sets registered via the `yiirocks/svg-inline.iconSets` config param (see {@see IconSetInterface}).
 * These are resolved dynamically through `__call()`, not declared as real interface methods, so that the
 * base package has no compile-time dependency on the extension packages that provide them.
 * @method bootstrap(string $name): self First-party, see `yiirocks/svg-inline-bootstrap`.
 * @method fai(string $name, ?string $style = null): self First-party, see `yiirocks/svg-inline-fontawesome`.
 */
interface SvgInlineInterface
{
    public function __call(string $name, array $value): self;

    public function file(string $file): self;
}
