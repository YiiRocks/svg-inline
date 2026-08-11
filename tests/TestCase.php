<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline\tests;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use YiiRocks\SvgInline\SvgInline;
use YiiRocks\SvgInline\SvgInlineInterface;
use YiiRocks\SvgInline\tests\Support\FakeIconSet;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Config\Config;
use Yiisoft\Config\ConfigPaths;
use Yiisoft\Config\Modifier\RecursiveMerge;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Files\FileHelper;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Aliases $aliases;
    protected ContainerInterface $container;
    protected SvgInline $svgInline;

    protected function setUp(): void
    {
        parent::setUp();
        $config = new Config(
            new ConfigPaths(dirname(__DIR__), 'config'),
            '/',
            [RecursiveMerge::groups('params')],
        );
        $definitions = $config->get('di')
            + [
                LoggerInterface::class => NullLogger::class,
                FakeIconSet::class => [
                    'class' => FakeIconSet::class,
                    'setFallbackIcon()' => ['@root/src/fallbackIcon.svg'],
                    'setFill()' => ['currentColor'],
                ],
            ];
        $definitions[SvgInlineInterface::class] = [
            'class' => SvgInline::class,
            '__construct()' => ['iconSets' => ['iconset' => FakeIconSet::class]],
            'setFallbackIcon()' => ['@root/src/fallbackIcon.svg'],
            'setFill()' => ['currentColor'],
        ];
        $containerConfig = ContainerConfig::create()->withDefinitions($definitions);
        $this->container = new Container($containerConfig);
        $this->aliases = $this->container->get(Aliases::class);
        $this->aliases->set('@root', dirname(__DIR__));
        $this->aliases->set('@assets', '@root/tests/assets');
        $this->aliases->set('@assetsUrl', '/baseUrl');
        $this->aliases->set('@vendor', '@root/vendor');
        $this->aliases->set('@npm', '@vendor/npm-asset');
        $this->svgInline = $this->container->get(SvgInlineInterface::class);
        $this->svgInline->setFallbackIcon('@root/src/fallbackIcon.svg');
    }

    protected function tearDown(): void
    {
        $this->removeAssets('@assets');
        parent::tearDown();
    }

    protected function removeAssets(string $basePath): void
    {
        $dir = $this->aliases->get($basePath);
        if (!is_dir($dir)) {
            return;
        }
        $handle = opendir($dir);
        if ($handle === false) {
            throw new Exception("Unable to open directory: $dir");
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
