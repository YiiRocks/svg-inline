<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

/**
 * Implemented by extension packages (e.g. `yiirocks/svg-inline-bootstrap`,
 * `yiirocks/svg-inline-fontawesome`) that register an icon set with the base {@see SvgInline} service via
 * the `yiirocks/svg-inline.iconSets` config param, so that e.g. `$svg->bootstrap('name')` resolves to
 * this service and `name()` builds the requested icon.
 */
interface IconSetInterface extends SvgInlineInterface
{
    /**
     * Resolves an icon name (and optional style/variant) to icon properties.
     *
     * @param string $name name of the icon
     * @param null|string $style style/variant of the icon, for icon sets that have one
     * @return IconInterface component object
     */
    public function name(string $name, ?string $style = null): IconInterface;
}
