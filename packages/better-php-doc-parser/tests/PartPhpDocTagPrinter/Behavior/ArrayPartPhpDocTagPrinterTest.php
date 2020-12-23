<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PartPhpDocTagPrinter\Behavior;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PartPhpDocTagPrinter\Behavior\Source\PhpDocTagNodeWithArrayPrinter;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration;
/**
 * @see \Rector\BetterPhpDocParser\PartPhpDocTagPrinter\Behavior\ArrayPartPhpDocTagPrinterTrait
 */
final class ArrayPartPhpDocTagPrinterTest extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    /**
     * @var PhpDocTagNodeWithArrayPrinter
     */
    private $phpDocTagNodeWithArrayPrinter;
    protected function setUp() : void
    {
        $this->phpDocTagNodeWithArrayPrinter = new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PartPhpDocTagPrinter\Behavior\Source\PhpDocTagNodeWithArrayPrinter();
    }
    /**
     * @param mixed[] $items
     * @dataProvider provideData()
     */
    public function test(array $items, string $key, string $expectedContent) : void
    {
        $tagValueNodeConfiguration = new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration();
        $output = $this->phpDocTagNodeWithArrayPrinter->printArrayItem($items, $key, $tagValueNodeConfiguration);
        $this->assertSame($expectedContent, $output);
    }
    public function provideData() : \Iterator
    {
        (yield [['strict' => 'yes'], 'option', 'option={"strict":"yes"}']);
        // bool
        (yield [['strict' => \false], 'option', 'option={"strict":false}']);
        // multiple items, separated by comma
        (yield [['less' => 'NO', 'more' => 'YES'], 'what', 'what={"less":"NO", "more":"YES"}']);
        // preslash
        (yield [['\\John'], 'name', 'name={"\\John"}']);
        (yield [['0', '3023', '3610'], 'choices', 'choices={"0", "3023", "3610"}']);
    }
}
