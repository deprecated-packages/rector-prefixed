<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class AutoImportNamesParameter74Test extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP 7.4
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImportNames74');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [
            # this class causes to "partial_expression.php.inc" to fail
            \_PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector::class => [],
            \_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [\_PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class]],
        ];
    }
}
