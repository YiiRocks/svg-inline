<?php

namespace YiiRocks\SvgInline\tests;

class SvgInlineTest extends TestCase
{
    public function testBasic(): void
    {
        $this->assertStringContainsString('stroke="gold"', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringNotContainsString('Test Comment', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringContainsString('stroke-width="40" stroke="currentColor" fill="none"', $this->svgInline->file('nonexistent.svg')->render());
    }

    public function testBasicBootstrap(): void
    {
        $this->assertStringNotContainsString('width', $this->svgInline->bootstrap('award')->render());
        $this->assertStringNotContainsString('height', $this->svgInline->bootstrap('award')->render());
    }

    public function testBasicFontAwesome(): void
    {
        $this->assertStringNotContainsString('width', $this->svgInline->fai('cookie')->render());
        $this->assertStringNotContainsString('height', $this->svgInline->fai('cookie')->render());
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('class="yourClass"', $this->svgInline->file('@root/tests/test1.svg')->class('yourClass')->render());
    }

    public function testCss(): void
    {
        $this->assertStringContainsString('style="text-align: center;"', $this->svgInline->file('@root/tests/test1.svg')->css(['text-align' => 'center'])->render());
        $this->assertStringContainsString('style="text-align: center;"', $this->svgInline->file('@root/tests/test1.svg')->css(['text-align' => 'center'])->render());
    }

    public function testFill(): void
    {
        $this->assertStringContainsString('fill="currentColor"', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringNotContainsString('fill="currentColor"', $this->svgInline->file('@root/tests/test1.svg')->fill('')->render());
        $this->assertStringContainsString('fill="#003865"', $this->svgInline->file('@root/tests/test1.svg')->fill('#003865')->render());
    }

    public function testHeight(): void
    {
        $this->assertStringNotContainsString(' height', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->height(-42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->height(42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test2.svg')->height(42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test3.svg')->height(42)->render());
    }

    public function testId(): void
    {
        $this->assertStringContainsString('id="DemoId"', $this->svgInline->file('@root/tests/test.svg')->id('DemoId')->render());
    }

    public function testReset(): void
    {
        $firstRun = $this->svgInline->file('@root/tests/test1.svg')->class('yourClass')->render();
        $secondRun = $this->svgInline->file('@root/tests/test1.svg')->render();

        $this->assertNotEquals($firstRun, $secondRun);
    }

    public function testSizeConvert(): void
    {
        $this->assertStringContainsString('width="672" height="672"', $this->svgInline->file('@root/tests/test2.svg')->render());
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', $this->svgInline->file('@root/tests/test1.svg')->title('Demo Title')->render());
    }

    public function testWidth(): void
    {
        $this->assertStringNotContainsString(' width', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->width(-42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->width(42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test2.svg')->width(42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test3.svg')->width(42)->render());
    }
}
