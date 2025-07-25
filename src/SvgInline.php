<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Psr\Container\ContainerInterface;
use YiiRocks\SvgInline\Bootstrap\SvgInlineBootstrap;
use YiiRocks\SvgInline\Bootstrap\SvgInlineBootstrapInterface;
use YiiRocks\SvgInline\FontAwesome\SvgInlineFontAwesome;
use YiiRocks\SvgInline\FontAwesome\SvgInlineFontAwesomeInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

use function explode;
use function libxml_clear_errors;
use function libxml_use_internal_errors;
use function round;
use function ucfirst;

/**
 * SvgInline provides a quick and easy way to access icons.
 */
class SvgInline implements NoEncodeStringableInterface, SvgInlineInterface
{
    /** @var array Values for converting various units to pixels */
    /** @psalm-suppress InvalidOperand */
    private const PIXEL_MAP = [
        'px' => 1,
        'em' => 16,
        'ex' => 16 / 2,
        'pt' => 16 / 12,
        'pc' => 16,
        'in' => 16 * 6,
        'cm' => 16 / (2.54 / 6),
        'mm' => 16 / (25.4 / 6),
    ];

    /** @var Aliases Object used to resolve aliases */
    protected Aliases $aliases;

    /** @var array Class property */
    /** @psalm-suppress PropertyNotSetInConstructor */
    protected array $class;

    /** @var string Backup icon in case requested icon cannot be found */
    /** @psalm-suppress PropertyNotSetInConstructor */
    protected string $fallbackIcon;

    /** @var string Color of the icon. Set to empty string to disable this attribute
     *              Applies only to SVG tag, not any paths below */
    /** @psalm-suppress PropertyNotSetInConstructor */
    protected string $fill;

    /** @var int height of the svg */
    protected ?int $svgHeight = null;

    /** @var array additional properties for the icon not set with Options */
    protected ?array $svgProperties = null;

    /** @var int width of the svg */
    protected ?int $svgWidth = null;

    /** $var ContainerInterface $container */
    private ContainerInterface $container;

    /** @var IconInterface icon properties */
    private IconInterface $icon;

    /** @var DOMDocument SVG file */
    private ?DOMDocument $svg = null;

    /** @var DOMElement SVG */
    private ?DOMElement $svgElement = null;

    /**
     * @param Aliases $aliases
     * @param ContainerInterface $container
     */
    public function __construct(
        Aliases $aliases,
        ContainerInterface $container,
        IconInterface $icon
    ) {
        $this->aliases = $aliases;
        $this->container = $container;
        $this->icon = $icon;
    }

    /**
     * Magic function, sets icon properties.
     *
     * @param string $name  property name
     * @param array  $value property value
     * @return self updated object
     */
    #[\Override]
    public function __call(string $name, array $value): SvgInlineInterface
    {
        $new = clone $this;
        $function = 'set' . ucfirst($name);
        $new->icon->$function($value[0]);
        return $new;
    }

    /**
     * Magic function, call render to return the SVG string.
     *
     * @return string SVG data
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Sets the Bootstrap Icon
     *
     * @param string $name name of the icon
     * @return SvgInlineInterface component object
     */
    #[\Override]
    public function bootstrap(string $name): SvgInlineInterface
    {
        /** @psalm-var SvgInlineBootstrap $bootstrap */
        $bootstrap = $this->container->get(SvgInlineBootstrapInterface::class);
        /** @psalm-suppress InaccessibleProperty */
        $bootstrap->icon = $bootstrap->name($name);

        return $bootstrap;
    }

    /**
     * Sets the Font Awesome Icon
     *
     * @param string $name name of the icon
     * @param null|string $style style of the icon
     * @return SvgInlineInterface component object
     */
    #[\Override]
    public function fai(string $name, ?string $style = null): SvgInlineInterface
    {
        /** @psalm-var SvgInlineFontAwesome $fai */
        $fai = $this->container->get(SvgInlineFontAwesomeInterface::class);
        /** @psalm-suppress InaccessibleProperty */
        $fai->icon = $fai->name($name, $style);

        return $fai;
    }

    /**
     * Sets the filename
     *
     * @param string $file name of the icon, or filename
     * @return SvgInlineInterface component object
     */
    #[\Override]
    public function file(string $file): SvgInlineInterface
    {
        $this->icon = new Icon();
        $fileName = $this->aliases->get($file);
        $this->icon->setName($fileName);

        return $this;
    }

    /**
     * Load SVG file. Falls back to default if not found.
     *
     * @see $fallbackIcon
     */
    public function loadSvg(): void
    {
        $iconFile = (string) $this->icon->get('name');
        /** @psalm-var DOMDocument $this->svg */
        if (!$this->svg->load($iconFile, LIBXML_NOBLANKS)) {
            $this->svg->load($this->fallbackIcon, LIBXML_NOBLANKS);
        }

        $this->removeDomNodes($this->svg, '//comment()');
        /** @psalm-var DOMElement $this->svgElement */
        $this->svgElement = $this->svg->getElementsByTagName('svg')->item(0);
        $this->class = ['class' => $this->icon->get('class')];
    }

    /**
     * Returns the SVG string.
     *
     * @return string SVG data
     */
    public function render(): string
    {
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $this->svg = new DOMDocument();

        $this->loadSvg();
        $this->setSvgSize();
        $this->setSvgProperties();
        $this->setSvgAttributes();

        return $this->svg->saveXML($this->svgElement);
    }

    /**
     * @see $fallbackIcon
     * @param string $value
     * @return void
     */
    public function setFallbackIcon(string $value): void
    {
        $this->fallbackIcon = $this->aliases->get($value);
    }

    /**
     * @see $fill
     * @param string $value
     * @return void
     */
    public function setFill(string $value): void
    {
        $this->fill = $value;
    }

    /**
     * Determines size of the SVG element.
     *
     * @return void
     */
    protected function setSvgSize(): void
    {
        /** @psalm-var DOMElement $this->svgElement */
        $this->svgWidth = $this->getPixelValue($this->svgElement->getAttribute('width'));
        $this->svgHeight = $this->getPixelValue($this->svgElement->getAttribute('height'));
        $this->svgProperties['width'] = $this->svgWidth;
        $this->svgProperties['height'] = $this->svgHeight;

        if ($this->svgElement->hasAttribute('viewBox')) {
            [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->svgElement->getAttribute('viewBox'));
            $this->svgWidth = (int) $xEnd - (int) $xStart;
            $this->svgHeight = (int) $yEnd - (int) $yStart;

            $this->svgElement->removeAttribute('width');
            $this->svgElement->removeAttribute('height');
            unset($this->svgProperties['width'], $this->svgProperties['height']);
        }

        $width = $this->icon->get('width');
        $height = $this->icon->get('height');
        if ($width || $height) {
            $this->svgProperties['width'] = $width ?? round((int) $height * $this->svgWidth / $this->svgHeight);
            $this->svgProperties['height'] = $height ?? round((int) $width * $this->svgHeight / $this->svgWidth);
        }
    }

    /**
     * Converts various sizes to pixels.
     *
     * @param string $size
     * @return int
     */
    private function getPixelValue(string $size): int
    {
        $trimmedSize = trim($size);
        $unit = substr($trimmedSize, -2);

        if (isset(self::PIXEL_MAP[$unit])) {
            $trimmedSize = (float) $trimmedSize * (float) self::PIXEL_MAP[$unit];
        }

        return (int) round((float) $trimmedSize);
    }

    /**
     * Removes nodes from a DOMDocument
     *
     * @param DOMDocument $dom
     * @string $expression
     * @return void
     */
    private function removeDomNodes(DOMDocument $dom, string $expression): void
    {
        $xpath = new DOMXPath($dom);
        while ($node = $xpath->query($expression)->item(0)) {
            if ($node instanceof DOMNode && $node->parentNode) {
                $node->parentNode->removeChild($node);
            }
        }
    }

    /**
     * Adds the properties to the SVG.
     *
     * @return void
     */
    private function setSvgAttributes(): void
    {
        /** @psalm-var DOMDocument $this->svg */
        $titleElement = $this->svg->createElement('title', $this->icon->getTitle());
        /** @psalm-var DOMElement $this->svgElement */
        $this->svgElement->insertBefore($titleElement, $this->svgElement->firstChild);

        /** @psalm-var array $this->svgProperties */
        foreach ($this->svgProperties as $key => $value) {
            $this->svgElement->removeAttribute((string) $key);
            if (!empty($value)) {
                $this->svgElement->setAttribute((string) $key, (string) $value);
            }
        }
    }

    /**
     * Prepares the values to be set on the SVG.
     *
     * @return void
     */
    private function setSvgProperties(): void
    {
        $this->svgProperties['aria-hidden'] = 'true';
        $this->svgProperties['role'] = 'img';
        $this->svgProperties['id'] = $this->icon->get('id');
        $this->svgProperties['class'] = $this->class['class'];

        $css = $this->icon->get('css');
        if (is_array($css)) {
            /** @psalm-var array<string, string> $css */
            $this->svgProperties['style'] = Html::cssStyleFromArray($css);
        }

        $this->svgProperties['fill'] = $this->icon->get('fill') ?? $this->fill;
    }
}
