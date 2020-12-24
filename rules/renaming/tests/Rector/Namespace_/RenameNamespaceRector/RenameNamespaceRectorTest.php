<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Namespace_\RenameNamespaceRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNamespaceRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::OLD_TO_NEW_NAMESPACES => ['OldNamespace' => 'NewNamespace', '_PhpScopere8e811afab72\\OldNamespaceWith\\OldSplitNamespace' => '_PhpScopere8e811afab72\\NewNamespaceWith\\NewSplitNamespace', '_PhpScopere8e811afab72\\Old\\Long\\AnyNamespace' => '_PhpScopere8e811afab72\\Short\\AnyNamespace', 'PHPUnit_Framework_' => 'PHPUnit\\Framework\\']]];
    }
}
