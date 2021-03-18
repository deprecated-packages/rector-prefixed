<?php

declare (strict_types=1);
namespace Rector\Tests\Symfony\Rector\Attribute\ExtractAttributeRouteNameConstantsRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 8.0
 */
final class ExtractAttributeRouteNameConstantsRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo $inputFile, string $expectedExtraFileName, string $expectedExtraContentFilePath) : void
    {
        $this->doTestFileInfo($inputFile);
        $this->doTestExtraFile($expectedExtraFileName, $expectedExtraContentFilePath);
    }
    /**
     * @return Iterator<string[]|SmartFileInfo[]>
     */
    public function provideData() : \Iterator
    {
        (yield [new \RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc'), 'src/ValueObject/Routing/RouteName.php', __DIR__ . '/Source/extra_file.php']);
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
