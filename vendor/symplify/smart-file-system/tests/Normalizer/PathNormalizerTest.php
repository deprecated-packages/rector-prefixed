<?php

declare (strict_types=1);
namespace RectorPrefix20210506\Symplify\SmartFileSystem\Tests\Normalizer;

use Iterator;
use RectorPrefix20210506\PHPUnit\Framework\TestCase;
use RectorPrefix20210506\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
final class PathNormalizerTest extends \RectorPrefix20210506\PHPUnit\Framework\TestCase
{
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    protected function setUp() : void
    {
        $this->pathNormalizer = new \RectorPrefix20210506\Symplify\SmartFileSystem\Normalizer\PathNormalizer();
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $inputPath, string $expectedNormalizedPath) : void
    {
        $normalizedPath = $this->pathNormalizer->normalizePath($inputPath);
        $this->assertSame($expectedNormalizedPath, $normalizedPath);
    }
    /**
     * @return Iterator<string[]>
     */
    public function provideData() : \Iterator
    {
        // based on Linux
        (yield ['/any/path', '/any/path']);
        (yield ['RectorPrefix20210506\\any\\path', '/any/path']);
    }
}
