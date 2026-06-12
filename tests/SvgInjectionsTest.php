<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline\tests;

use YiiRocks\SvgInline\SvgInjections;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;
use Yiisoft\Yii\View\Renderer\LayoutParametersInjectionInterface;

final class SvgInjectionsTest extends TestCase
{
    private SvgInjections $injections;

    protected function setUp(): void
    {
        parent::setUp();
        $this->injections = $this->container->get(SvgInjections::class);
    }

    public function testImplementsCommonParametersInjection(): void
    {
        $this->assertInstanceOf(CommonParametersInjectionInterface::class, $this->injections);
    }

    public function testImplementsLayoutParametersInjection(): void
    {
        $this->assertInstanceOf(LayoutParametersInjectionInterface::class, $this->injections);
    }

    public function testGetCommonParametersContainsSvgInline(): void
    {
        $params = $this->injections->getCommonParameters();
        $this->assertArrayHasKey('svg', $params);
        $this->assertSame($this->svgInline, $params['svg']);
    }

    public function testGetLayoutParametersContainsSvgInline(): void
    {
        $params = $this->injections->getLayoutParameters();
        $this->assertArrayHasKey('svg', $params);
        $this->assertSame($this->svgInline, $params['svg']);
    }
}
