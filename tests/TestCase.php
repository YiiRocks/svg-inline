<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline\tests;

use Psr\Container\ContainerInterface;
use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Composer\Config\Builder;
use Yiisoft\Di\Container;
use Yiisoft\Files\FileHelper;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Aliases $aliases
     */
    protected $aliases;

    /**
     * @var AssetManager $assetManager
     */
    protected $assetManager;

    /**
     * @var SvgInline $svgInline
     */
    protected $svgInline;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    protected function setUp(): void
    {
        parent::setUp();
        $config = require Builder::path('web');
        $this->container = new Container($config);
        $this->aliases = $this->container->get(Aliases::class);
        $this->aliases->set('@root', dirname(__DIR__, 1));
        $this->aliases->set('@assets', '@root/tests/assets');
        $this->aliases->set('@assetsUrl', '/baseUrl');
        $this->aliases->set('@vendor', '@root/vendor');
        $this->svgInline = $this->container->get(SvgInlineInterface::class);
        $this->svgInline->setFallbackIcon('@root/src/fallbackIcon.svg');
    }

    protected function tearDown(): void
    {
        $this->container = null;
        $this->removeAssets('@assets');
        parent::tearDown();
    }

    protected function removeAssets(string $basePath): void
    {
        $handle = opendir($dir = $this->aliases->get($basePath));
        if ($handle === false) {
            throw new \Exception("Unable to open directory: $dir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..' || $file === '.gitignore') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                FileHelper::removeDirectory($path);
            } else {
                FileHelper::unlink($path);
            }
        }
        closedir($handle);
    }
}