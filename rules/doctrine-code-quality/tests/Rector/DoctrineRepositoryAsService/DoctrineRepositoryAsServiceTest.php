<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use _PhpScoper0a6b37af0871\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector
 * @see \Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector
 * @see \Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector
 */
final class DoctrineRepositoryAsServiceTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
            \_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class => [],
        ];
    }
}
