<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector;

use Iterator;
use _PhpScoper0a6b37af0871\Nette\Utils\Html;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => [
            new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
            new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoper0a6b37af0871\Nette\Utils\Html::class, 'add', 'addHtml'),
            new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('*Presenter', 'run', '__invoke'),
            new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename::class, 'preventPHPStormRefactoring', 'gone'),
            // with array key
            new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(\_PhpScoper0a6b37af0871\Nette\Utils\Html::class, 'addToArray', 'addToHtmlArray', 'hey'),
        ]]];
    }
}
