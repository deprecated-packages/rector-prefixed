<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Namespace_\RenameNamespaceRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNamespaceRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::OLD_TO_NEW_NAMESPACES => ['OldNamespace' => 'NewNamespace', '_PhpScoper2a4e7ab1ecbc\\OldNamespaceWith\\OldSplitNamespace' => '_PhpScoper2a4e7ab1ecbc\\NewNamespaceWith\\NewSplitNamespace', '_PhpScoper2a4e7ab1ecbc\\Old\\Long\\AnyNamespace' => '_PhpScoper2a4e7ab1ecbc\\Short\\AnyNamespace', 'PHPUnit_Framework_' => 'PHPUnit\\Framework\\']]];
    }
}
