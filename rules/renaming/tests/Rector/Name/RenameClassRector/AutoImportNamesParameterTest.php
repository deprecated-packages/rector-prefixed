<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class AutoImportNamesParameterTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImportNames');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [
            # this class causes to "partial_expression.php.inc" to fail
            \_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector::class => [],
            \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class]],
        ];
    }
}
