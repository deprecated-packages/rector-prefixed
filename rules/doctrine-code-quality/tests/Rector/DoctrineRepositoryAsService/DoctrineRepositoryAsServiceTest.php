<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService;

use Iterator;
use _PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use _PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector
 * @see \Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector
 * @see \Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector
 */
final class DoctrineRepositoryAsServiceTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [
            # order matters, this needs to be first to correctly detect parent repository
            \_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class => [],
            \_PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector::class => [],
            \_PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class => [],
            \_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class => [],
        ];
    }
}
