<?php

namespace YiiRocks\SvgInline\tests;

class SvgInlineTest extends TestCase
{
    public function testBasic(): void
    {
        $this->assertStringContainsString('stroke="gold"', $this->svgInline->file('@root/tests/test.svg'));
        $this->assertStringNotContainsString('Test Comment', $this->svgInline->file('@root/tests/test.svg'));
        $this->assertStringContainsString('stroke-width="40" stroke="currentColor" fill="none"', $this->svgInline->file('nonexistent.svg'));
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('class="yourClass"', $this->svgInline->file('@root/tests/test.svg')->class('yourClass'));
    }

    public function testCss(): void
    {
        $this->assertStringContainsString('style="text-align: center;"', $this->svgInline->file('cookie')->css(['text-align' => 'center']));
        $this->assertStringContainsString('style="text-align: center;"', $this->svgInline->file('github', 'brands')->css(['text-align' => 'center']));
    }

    public function testFill(): void
    {
        $this->assertStringContainsString('fill="currentColor"', $this->svgInline->file('@root/tests/test.svg'));
        $this->assertStringNotContainsString('fill="currentColor"', $this->svgInline->file('@root/tests/test.svg')->fill(''));
        $this->assertStringContainsString('fill="#003865"', $this->svgInline->file('@root/tests/test.svg')->fill('#003865'));
    }

    public function testHeight(): void
    {
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test.svg')->height(-42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test.svg')->height(42));
    }

    public function testId(): void
    {
        $this->assertStringContainsString('id="DemoId"', $this->svgInline->file('@root/tests/test.svg')->id('DemoId'));
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', $this->svgInline->file('@root/tests/test.svg')->title('Demo Title'));
    }

    public function testWidth(): void
    {
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test.svg')->width(-42));
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test.svg')->width(42));
    }
}
