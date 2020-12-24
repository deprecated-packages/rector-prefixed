<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Html;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => [
            new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
            new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Html::class, 'add', 'addHtml'),
            new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('*Presenter', 'run', '__invoke'),
            new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename::class, 'preventPHPStormRefactoring', 'gone'),
            // with array key
            new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Html::class, 'addToArray', 'addToHtmlArray', 'hey'),
        ]]];
    }
}
