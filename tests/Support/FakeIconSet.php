<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline\tests\Support;

use YiiRocks\SvgInline\Icon;
use YiiRocks\SvgInline\IconInterface;
use YiiRocks\SvgInline\IconSetInterface;
use YiiRocks\SvgInline\SvgInline;
use Yiisoft\Html\Html;

/**
 * Test-only icon set standing in for a real extension package (e.g. `yiirocks/svg-inline-bootstrap`).
 *
 * It lets the base package exercise its icon-set dispatch and clone-immutability logic end-to-end
 * (real `$svg->iconset('award')` calls, not mocks) without depending on any extension package being
 * installed. It mirrors the shape of a real icon set:
 *  - `name()` resolves an icon name to a fixture SVG under `tests/icons/`, builds the icon, assigns it
 *    to the inherited `$icon`, and returns it;
 *  - `setSvgSize()` overrides the base to append a CSS class (instead of pixel sizes) when no explicit
 *    width/height was requested, exactly as the bootstrap/fontawesome extensions do.
 */
final class FakeIconSet extends SvgInline implements IconSetInterface
{
    public function name(string $name, ?string $style = null): IconInterface
    {
        $icon = new Icon();
        $icon->setName($this->aliases->get("@root/tests/icons/{$name}.svg"));
        $this->icon = $icon;
        return $icon;
    }

    protected function setSvgSize(): void
    {
        parent::setSvgSize();
        $width = $this->icon->get('width');
        $height = $this->icon->get('height');
        if (!$width && !$height) {
            Html::addCssClass($this->class, 'iconset');
        }
    }
}
