<?php

namespace YiiRocks\SvgInline\tests;

class SvgInlineTest extends TestCase
{
    public function testBasic(): void
    {
        $this->assertStringContainsString('stroke="gold"', $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringNotContainsString('Test Comment', $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringContainsString('stroke-width="40" stroke="currentColor" fill="none"', $this->svgInline->file('nonexistent.svg'));
    }

    public function testBasicBootstrap(): void
    {
        $this->assertStringNotContainsString('width', $this->svgInline->bootstrap('award'));
        $this->assertStringNotContainsString('height', $this->svgInline->bootstrap('award'));
    }

    public function testBasicFontAwesome(): void
    {
        $this->assertStringNotContainsString('width', $this->svgInline->fai('cookie'));
        $this->assertStringNotContainsString('height', $this->svgInline->fai('cookie'));
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('class="yourClass"', $this->svgInline->file('@root/tests/test1.svg')->class('yourClass'));
    }

    public function testCss(): void
    {
        $this->assertStringContainsString('style="text-align: center;"', $this->svgInline->file('cookie')->css(['text-align' => 'center']));
        $this->assertStringContainsString('style="text-align: center;"', $this->svgInline->file('github', 'brands')->css(['text-align' => 'center']));
    }

    public function testFill(): void
    {
        $this->assertStringContainsString('fill="currentColor"', $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringNotContainsString('fill="currentColor"', $this->svgInline->file('@root/tests/test1.svg')->fill(''));
        $this->assertStringContainsString('fill="#003865"', $this->svgInline->file('@root/tests/test1.svg')->fill('#003865'));
    }

    public function testHeight(): void
    {
        $this->assertStringNotContainsString(' height', $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->height(-42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->height(42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test2.svg')->height(42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test3.svg')->height(42));
    }

    public function testId(): void
    {
        $this->assertStringContainsString('id="DemoId"', $this->svgInline->file('@root/tests/test.svg')->id('DemoId'));
    }

    public function testSizeConvert(): void
    {
        $this->assertStringContainsString('width="672" height="672"', $this->svgInline->file('@root/tests/test2.svg'));
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', $this->svgInline->file('@root/tests/test1.svg')->title('Demo Title'));
    }

    public function testWidth(): void
    {
        $this->assertStringNotContainsString(' width', $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->width(-42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->width(42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test2.svg')->width(42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test3.svg')->width(42));
    }
}
