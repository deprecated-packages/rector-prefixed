<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService;

use Iterator;
use Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector;
use Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector
 * @see \Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector
 * @see \Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector
 */
final class DoctrineRepositoryAsServiceTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210107\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
            \Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class => [],
            \Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector::class => [],
            \Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class => [],
            \Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class => [],
        ];
    }
}
