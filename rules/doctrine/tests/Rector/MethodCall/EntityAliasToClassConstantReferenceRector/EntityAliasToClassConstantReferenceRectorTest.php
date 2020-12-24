<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Tests\Rector\MethodCall\EntityAliasToClassConstantReferenceRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\EntityAliasToClassConstantReferenceRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class EntityAliasToClassConstantReferenceRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\EntityAliasToClassConstantReferenceRector::class => [\_PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall\EntityAliasToClassConstantReferenceRector::ALIASES_TO_NAMESPACES => ['App' => '_PhpScopere8e811afab72\\App\\Entity']]];
    }
}
