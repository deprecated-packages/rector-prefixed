<?php

declare (strict_types=1);
namespace Rector\Symfony3\Tests\Rector\MethodCall\StringFormTypeToClassRector;

use Iterator;
use Rector\Core\Configuration\Option;
use Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo;
final class WithContainerTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithContainer');
    }
    protected function setParameter(string $name, $value) : void
    {
        parent::setParameter(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/Source/custom_container.xml');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class;
    }
}
