<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\FileSystem;

use Iterator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\Skipper\FileSystem\PathNormalizer;
use _PhpScoper0a6b37af0871\Symplify\Skipper\HttpKernel\SkipperKernel;
final class PathNormalizerTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PathNormalizer
     */
    private $pathNormalizer;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Symplify\Skipper\HttpKernel\SkipperKernel::class);
        $this->pathNormalizer = $this->getService(\_PhpScoper0a6b37af0871\Symplify\Skipper\FileSystem\PathNormalizer::class);
    }
    /**
     * @dataProvider providePaths
     */
    public function testPaths(string $path, string $expected) : void
    {
        $this->assertSame($expected, $this->pathNormalizer->normalizeForFnmatch($path));
    }
    public function providePaths() : \Iterator
    {
        (yield ['path/with/no/asterisk', 'path/with/no/asterisk']);
        (yield ['*path/with/asterisk/begin', '*path/with/asterisk/begin*']);
        (yield ['path/with/asterisk/end*', '*path/with/asterisk/end*']);
        (yield ['*path/with/asterisk/begin/and/end*', '*path/with/asterisk/begin/and/end*']);
        (yield [__DIR__ . '/Fixture/path/with/../in/it', __DIR__ . '/Fixture/path/in/it']);
        (yield [__DIR__ . '/Fixture/path/with/../../in/it', __DIR__ . '/Fixture/in/it']);
    }
}
