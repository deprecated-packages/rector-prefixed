<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Namespace_\RenameNamespaceRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNamespaceRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::OLD_TO_NEW_NAMESPACES => ['OldNamespace' => 'NewNamespace', '_PhpScoperb75b35f52b74\\OldNamespaceWith\\OldSplitNamespace' => '_PhpScoperb75b35f52b74\\NewNamespaceWith\\NewSplitNamespace', '_PhpScoperb75b35f52b74\\Old\\Long\\AnyNamespace' => '_PhpScoperb75b35f52b74\\Short\\AnyNamespace', 'PHPUnit_Framework_' => 'PHPUnit\\Framework\\']]];
    }
}
