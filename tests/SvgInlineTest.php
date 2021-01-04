<?php

namespace YiiRocks\SvgInline\tests;

class SvgInlineTest extends TestCase
{
    public function testBasic(): void
    {
        $this->assertStringContainsString('stroke="gold"', (string) $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringNotContainsString('Test Comment', (string) $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringContainsString('stroke-width="40" stroke="currentColor" fill="none"', (string) $this->svgInline->file('nonexistent.svg'));
    }

    public function testBasicBootstrap(): void
    {
        $this->assertStringNotContainsString('width', (string) $this->svgInline->bootstrap('award'));
        $this->assertStringNotContainsString('height', (string) $this->svgInline->bootstrap('award'));
    }

    public function testBasicFontAwesome(): void
    {
        $this->assertStringNotContainsString('width', (string) $this->svgInline->fai('cookie'));
        $this->assertStringNotContainsString('height', (string) $this->svgInline->fai('cookie'));
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('class="yourClass"', (string) $this->svgInline->file('@root/tests/test1.svg')->class('yourClass'));
    }

    public function testCss(): void
    {
        $this->assertStringContainsString('style="text-align: center;"', (string) $this->svgInline->file('@root/tests/test1.svg')->css(['text-align' => 'center']));
        $this->assertStringContainsString('style="text-align: center;"', (string) $this->svgInline->file('@root/tests/test1.svg')->css(['text-align' => 'center']));
    }

    public function testFill(): void
    {
        $this->assertStringContainsString('fill="currentColor"', (string) $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringNotContainsString('fill="currentColor"', (string) $this->svgInline->file('@root/tests/test1.svg')->fill(''));
        $this->assertStringContainsString('fill="#003865"', (string) $this->svgInline->file('@root/tests/test1.svg')->fill('#003865'));
    }

    public function testHeight(): void
    {
        $this->assertStringNotContainsString(' height', (string) $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test1.svg')->height(-42));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test1.svg')->height(42));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test2.svg')->height(42));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test3.svg')->height(42));
    }

    public function testId(): void
    {
        $this->assertStringContainsString('id="DemoId"', (string) $this->svgInline->file('@root/tests/test.svg')->id('DemoId'));
    }

    public function testSizeConvert(): void
    {
        $this->assertStringContainsString('width="672" height="672"', (string) $this->svgInline->file('@root/tests/test2.svg'));
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', (string) $this->svgInline->file('@root/tests/test1.svg')->title('Demo Title'));
    }

    public function testWidth(): void
    {
        $this->assertStringNotContainsString(' width', (string) $this->svgInline->file('@root/tests/test1.svg'));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test1.svg')->width(-42));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test1.svg')->width(42));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test2.svg')->width(42));
        $this->assertStringContainsString('width="42" height="42"', (string) $this->svgInline->file('@root/tests/test3.svg')->width(42));
    }

    public function testReset(): void
    {
        $firstRun = (string) $this->svgInline->file('@root/tests/test1.svg')->class('yourClass');
        $secondRun = (string) $this->svgInline->file('@root/tests/test1.svg');

        $this->assertNotEquals($firstRun, $secondRun);
    }
}
