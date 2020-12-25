<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\Namespace_\RenameNamespaceRector;

use Iterator;
use Rector\Renaming\Rector\Namespace_\RenameNamespaceRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNamespaceRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::class => [\Rector\Renaming\Rector\Namespace_\RenameNamespaceRector::OLD_TO_NEW_NAMESPACES => ['OldNamespace' => 'NewNamespace', '_PhpScoper50d83356d739\\OldNamespaceWith\\OldSplitNamespace' => '_PhpScoper50d83356d739\\NewNamespaceWith\\NewSplitNamespace', '_PhpScoper50d83356d739\\Old\\Long\\AnyNamespace' => '_PhpScoper50d83356d739\\Short\\AnyNamespace', 'PHPUnit_Framework_' => 'PHPUnit\\Framework\\']]];
    }
}
