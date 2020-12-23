<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Tests\ConfigResolver;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\ArrayInput;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\SetAwareConfigResolver;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Tests\ConfigResolver\Source\DummySetProvider;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class SetAwareConfigResolverTest extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    /**
     * @var SetAwareConfigResolver
     */
    private $setAwareConfigResolver;
    protected function setUp() : void
    {
        $this->setAwareConfigResolver = new \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\SetAwareConfigResolver(new \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Tests\ConfigResolver\Source\DummySetProvider());
    }
    /**
     * @dataProvider provideOptionsAndExpectedConfig()
     * @param mixed[] $options
     */
    public function testDetectFromInputAndProvideWithAbsolutePath(array $options, ?string $expectedConfig) : void
    {
        $resolvedConfigFileInfo = $this->setAwareConfigResolver->resolveFromInput(new \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\ArrayInput($options));
        if ($expectedConfig === null) {
            $this->assertNull($resolvedConfigFileInfo);
        } else {
            $this->assertSame($expectedConfig, $resolvedConfigFileInfo->getRealPath());
        }
    }
    public function provideOptionsAndExpectedConfig() : \Iterator
    {
        (yield [['--config' => 'README.md'], \getcwd() . '/README.md']);
        (yield [['-c' => 'README.md'], \getcwd() . '/README.md']);
        (yield [['--config' => \getcwd() . '/README.md'], \getcwd() . '/README.md']);
        (yield [['-c' => \getcwd() . '/README.md'], \getcwd() . '/README.md']);
        (yield [['--', 'sh', '-c' => '/bin/true'], null]);
    }
    public function testSetsNotFound() : void
    {
        $basicConfigFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/missing_set_config.php');
        $this->expectException(\_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Exception\SetNotFoundException::class);
        $this->setAwareConfigResolver->resolveFromParameterSetsFromConfigFiles([$basicConfigFileInfo]);
    }
    public function testPhpSetsFileInfos() : void
    {
        $basicConfigFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/php_config_with_sets.php');
        $setFileInfos = $this->setAwareConfigResolver->resolveFromParameterSetsFromConfigFiles([$basicConfigFileInfo]);
        $this->assertCount(1, $setFileInfos);
        $setFileInfo = $setFileInfos[0];
        $expectedSetFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/some_php_set.php');
        $this->assertEquals($expectedSetFileInfo, $setFileInfo);
    }
    public function testMissingFileInInput() : void
    {
        $this->expectException(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\Exception\FileNotFoundException::class);
        $arrayInput = new \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\ArrayInput(['--config' => 'someFile.yml']);
        $this->setAwareConfigResolver->resolveFromInput($arrayInput);
    }
}
