<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Tests\Normalizer;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
final class PathNormalizerTest extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    protected function setUp() : void
    {
        $this->pathNormalizer = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Normalizer\PathNormalizer();
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
        (yield ['_PhpScoper0a2ac50786fa\\any\\path', '/any/path']);
    }
}
