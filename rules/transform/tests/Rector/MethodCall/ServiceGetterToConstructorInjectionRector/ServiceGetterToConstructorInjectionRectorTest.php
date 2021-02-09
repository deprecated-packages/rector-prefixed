<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo;
final class ServiceGetterToConstructorInjectionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
    protected function provideConfigFileInfo() : ?\RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210209\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/configured_rule.php');
    }
}
