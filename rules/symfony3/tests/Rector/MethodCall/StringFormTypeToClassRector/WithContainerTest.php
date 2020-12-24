<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\Tests\Rector\MethodCall\StringFormTypeToClassRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class WithContainerTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithContainer');
    }
    protected function setParameter(string $name, $value) : void
    {
        parent::setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/Source/custom_container.xml');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class;
    }
}
