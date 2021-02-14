<?php

declare (strict_types=1);
namespace RectorPrefix20210214\Symplify\SmartFileSystem\Tests\Normalizer;

use Iterator;
use RectorPrefix20210214\PHPUnit\Framework\TestCase;
use RectorPrefix20210214\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
final class PathNormalizerTest extends \RectorPrefix20210214\PHPUnit\Framework\TestCase
{
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    protected function setUp() : void
    {
        $this->pathNormalizer = new \RectorPrefix20210214\Symplify\SmartFileSystem\Normalizer\PathNormalizer();
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
        (yield ['RectorPrefix20210214\\any\\path', '/any/path']);
    }
}
