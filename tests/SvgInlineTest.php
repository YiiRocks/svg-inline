<?php

namespace YiiRocks\SvgInline\tests;

use BadMethodCallException;

class SvgInlineTest extends TestCase
{
    public function testBasic(): void
    {
        $this->assertStringContainsString('stroke="gold"', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringNotContainsString('Test Comment', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringContainsString('stroke-width="40" stroke="currentColor" fill="none"', $this->svgInline->file('nonexistent.svg')->render());
    }

    public function testClass(): void
    {
        $this->assertStringContainsString('class="yourClass"', $this->svgInline->file('@root/tests/test1.svg')->class('yourClass')->render());
    }

    public function testCloneImmutability(): void
    {
        $this->assertNotSame($this->svgInline, $this->svgInline->class('yourClass'));
    }

    public function testCloneImmutabilityDoesNotLeakBetweenCalls(): void
    {
        $first = $this->svgInline->file('@root/tests/test1.svg');
        $second = $this->svgInline->file('@root/tests/test2.svg');

        $this->assertStringContainsString('<title>Test1</title>', $first->render());
        $this->assertStringContainsString('<title>Test2</title>', $second->render());
    }

    public function testCloneImmutabilityDoesNotLeakPropertyChanges(): void
    {
        $base = $this->svgInline->file('@root/tests/test1.svg');
        $withClass = $base->class('yourClass');

        $this->assertStringNotContainsString('class="yourClass"', $base->render());
        $this->assertStringContainsString('class="yourClass"', $withClass->render());
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

    public function testFillAttributeRemovedFromSource(): void
    {
        $this->assertStringNotContainsString('fill=', $this->svgInline->file('@root/tests/test7.svg')->fill('')->render());
    }

    public function testHeight(): void
    {
        $this->assertStringNotContainsString(' height', $this->svgInline->file('@root/tests/test1.svg')->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->height(-42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test1.svg')->height(42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test2.svg')->height(42)->render());
        $this->assertStringContainsString('width="42" height="42"', $this->svgInline->file('@root/tests/test3.svg')->height(42)->render());
    }

    public function testIconSetCloneImmutabilityDoesNotLeakBetweenCalls(): void
    {
        $award = $this->svgInline->iconset('award');
        $activity = $this->svgInline->iconset('activity');

        $this->assertStringContainsString('<title>Award</title>', $award->render());
        $this->assertStringContainsString('<title>Activity</title>', $activity->render());
    }

    public function testIconSetCloneImmutabilityDoesNotLeakPropertyChanges(): void
    {
        $award = $this->svgInline->iconset('award');
        $awardWithWidth = $award->width(42);

        $this->assertStringNotContainsString('width', $award->render());
        $this->assertStringContainsString('width="42"', $awardWithWidth->render());
    }

    public function testIconSetDispatch(): void
    {
        // A registered icon set (see FakeIconSet, wired up in TestCase) is resolved by __call() and
        // renders the file its name() resolved to. The derived title proves the right icon was built;
        // the CSS class proves the subclass's setSvgSize() override ran, and (like the real icon sets)
        // it sizes via that class rather than width/height attributes, which are stripped.
        $result = $this->svgInline->iconset('award')->render();

        $this->assertStringContainsString('<title>Award</title>', $result);
        $this->assertStringContainsString('class="iconset"', $result);
        $this->assertStringNotContainsString('width', $result);
        $this->assertStringNotContainsString('height', $result);
    }

    public function testId(): void
    {
        $this->assertStringContainsString('id="DemoId"', $this->svgInline->file('@root/tests/test.svg')->id('DemoId')->render());
    }

    public function testLibxmlErrorsCleared(): void
    {
        libxml_use_internal_errors(true);
        simplexml_load_string('<invalid');
        $this->assertNotEmpty(libxml_get_errors());

        $this->svgInline->file('@root/tests/test1.svg')->render();

        $this->assertEmpty(libxml_get_errors());
    }

    public function testPixelUnitConversion(): void
    {
        $this->assertStringContainsString('width="7" height="1"', $this->svgInline->file('@root/tests/test6.svg')->render());
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

    public function testSizeRounding(): void
    {
        $this->assertStringContainsString('height="13"', $this->svgInline->file('@root/tests/test5.svg')->width(42)->render());
        $this->assertStringContainsString('height="12"', $this->svgInline->file('@root/tests/test5.svg')->width(41)->render());
        $this->assertStringContainsString('width="137"', $this->svgInline->file('@root/tests/test5.svg')->height(41)->render());
        $this->assertStringContainsString('width="143"', $this->svgInline->file('@root/tests/test5.svg')->height(43)->render());
    }

    public function testTitle(): void
    {
        $this->assertStringContainsString('<title>Demo Title</title>', $this->svgInline->file('@root/tests/test1.svg')->title('Demo Title')->render());
    }

    public function testTitleDefault(): void
    {
        $this->assertStringContainsString('<title>Test1</title>', $this->svgInline->file('@root/tests/test1.svg')->render());
    }

    public function testToString(): void
    {
        $file = $this->svgInline->file('@root/tests/test1.svg');
        $this->assertSame($file->render(), (string) $file);
    }

    public function testUnknownMethodThrowsBadMethodCallException(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage(
            'Call to undefined method YiiRocks\SvgInline\SvgInline::nonexistentMethod(). It is not a '
                . 'registered icon set (is its package installed? see the "yiirocks/svg-inline" '
                . '"iconSets" config param) nor a valid icon property.',
        );

        $this->svgInline->file('@root/tests/test1.svg')->nonexistentMethod('x');
    }

    public function testViewBoxOriginAndPrecision(): void
    {
        $this->assertStringContainsString('height="200"', $this->svgInline->file('@root/tests/test4.svg')->width(100)->render());
        $this->assertStringContainsString('width="100"', $this->svgInline->file('@root/tests/test4.svg')->height(200)->render());
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
