<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

/**
 * Icon class to store all icon properties.
 */
class Icon implements IconInterface
{
    /** @var string Additional custom classes */
    private ?string $class = null;

    /** @var array Additional CSS attributes */
    private ?array $css = null;

    /** @var string Color of the icon. Set to empty string to disable this attribute */
    private ?string $fill = null;

    /**
     * @var int The height of the icon. This will dismiss the automatic height
     *          and width classes. If height is given without width, the latter
     *          will be calculated from the SVG size
     */
    private ?int $height = null;

    /**
     * @var string Id for the SVG tag.
     */
    private ?string $id = null;

    /**
     * @var string Valid path to an SVG image
     */
    private string $name = '';

    /** @var null|string Sets a title to the SVG output */
    private ?string $title = null;

    /**
     * @var int The width of the icon. This will dismiss the automatic height
     *          and width classes. If `width` is given without `height`, the
     *          latter will be calculated from the SVG size
     */
    private ?int $width = null;

    /**
     * @see $icon
     * @param string $key
     * @return mixed
     */
    #[\Override]
    public function get(string $key): mixed
    {
        return $this->$key ?? null;
    }

    /**
     * @see $name
     * @return string
     */
    #[\Override]
    public function getTitle(): string
    {
        return $this->title ?? ucfirst(basename($this->name, '.svg'));
    }

    public function setClass(string $value): void
    {
        $this->class = $value;
    }

    public function setCss(array $value): void
    {
        $this->css = $value;
    }

    public function setFill(string $value): void
    {
        $this->fill = $value;
    }

    public function setHeight(int $value): void
    {
        $this->height = abs($value);
    }

    public function setId(string $value): void
    {
        $this->id = $value;
    }

    public function setName(string $value): void
    {
        $this->name = $value;
    }

    public function setTitle(string $value): void
    {
        $this->title = $value;
    }

    public function setWidth(int $value): void
    {
        $this->width = abs($value);
    }
}
