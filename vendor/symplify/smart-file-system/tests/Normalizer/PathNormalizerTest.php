<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SmartFileSystem\Tests\Normalizer;

use Iterator;
use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Normalizer\PathNormalizer;
final class PathNormalizerTest extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    protected function setUp() : void
    {
        $this->pathNormalizer = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\Normalizer\PathNormalizer();
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
        (yield ['_PhpScopere8e811afab72\\any\\path', '/any/path']);
    }
}
