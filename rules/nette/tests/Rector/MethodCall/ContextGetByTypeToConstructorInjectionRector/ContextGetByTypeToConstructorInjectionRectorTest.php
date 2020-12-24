<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ContextGetByTypeToConstructorInjectionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector::class;
    }
}
