<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Tests\Normalizer;

use Iterator;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
final class PathNormalizerTest extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    protected function setUp() : void
    {
        $this->pathNormalizer = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Normalizer\PathNormalizer();
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $inputPath, string $expectedNormalizedPath) : void
    {
        $normalizedPath = $this->pathNormalizer->normalizePath($inputPath);
        $this->assertSame($expectedNormalizedPath, $normalizedPath);
    }
    public function provideData() : \Iterator
    {
        // based on Linux
        (yield ['/any/path', '/any/path']);
        (yield ['_PhpScoperb75b35f52b74\\any\\path', '/any/path']);
    }
}
