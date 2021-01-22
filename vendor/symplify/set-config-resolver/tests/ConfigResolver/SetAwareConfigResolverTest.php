<?php

declare (strict_types=1);
namespace RectorPrefix20210122\Symplify\SetConfigResolver\Tests\ConfigResolver;

use Iterator;
use RectorPrefix20210122\PHPUnit\Framework\TestCase;
use RectorPrefix20210122\Symfony\Component\Console\Input\ArrayInput;
use RectorPrefix20210122\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use RectorPrefix20210122\Symplify\SetConfigResolver\SetAwareConfigResolver;
use RectorPrefix20210122\Symplify\SetConfigResolver\Tests\ConfigResolver\Source\DummySetProvider;
use RectorPrefix20210122\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo;
final class SetAwareConfigResolverTest extends \RectorPrefix20210122\PHPUnit\Framework\TestCase
{
    /**
     * @var SetAwareConfigResolver
     */
    private $setAwareConfigResolver;
    protected function setUp() : void
    {
        $this->setAwareConfigResolver = new \RectorPrefix20210122\Symplify\SetConfigResolver\SetAwareConfigResolver(new \RectorPrefix20210122\Symplify\SetConfigResolver\Tests\ConfigResolver\Source\DummySetProvider());
    }
    /**
     * @dataProvider provideOptionsAndExpectedConfig()
     * @param mixed[] $options
     */
    public function testDetectFromInputAndProvideWithAbsolutePath(array $options, ?string $expectedConfig) : void
    {
        $resolvedConfigFileInfo = $this->setAwareConfigResolver->resolveFromInput(new \RectorPrefix20210122\Symfony\Component\Console\Input\ArrayInput($options));
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
        $this->expectException(\RectorPrefix20210122\Symplify\SetConfigResolver\Exception\SetNotFoundException::class);
        $basicConfigFileInfo = new \RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/missing_set_config.php');
        $this->setAwareConfigResolver->resolveFromParameterSetsFromConfigFiles([$basicConfigFileInfo]);
    }
    public function testPhpSetsFileInfos() : void
    {
        $basicConfigFileInfo = new \RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/php_config_with_sets.php');
        $setFileInfos = $this->setAwareConfigResolver->resolveFromParameterSetsFromConfigFiles([$basicConfigFileInfo]);
        $this->assertCount(1, $setFileInfos);
        $setFileInfo = $setFileInfos[0];
        $expectedSetFileInfo = new \RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/some_php_set.php');
        $this->assertEquals($expectedSetFileInfo, $setFileInfo);
    }
    public function testMissingFileInInput() : void
    {
        $this->expectException(\RectorPrefix20210122\Symplify\SmartFileSystem\Exception\FileNotFoundException::class);
        $arrayInput = new \RectorPrefix20210122\Symfony\Component\Console\Input\ArrayInput(['--config' => 'someFile.yml']);
        $this->setAwareConfigResolver->resolveFromInput($arrayInput);
    }
}
