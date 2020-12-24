<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector;

use Iterator;
use _PhpScoperb75b35f52b74\Nette\Utils\Html;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => [
            new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
            new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoperb75b35f52b74\Nette\Utils\Html::class, 'add', 'addHtml'),
            new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('*Presenter', 'run', '__invoke'),
            new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename::class, 'preventPHPStormRefactoring', 'gone'),
            // with array key
            new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(\_PhpScoperb75b35f52b74\Nette\Utils\Html::class, 'addToArray', 'addToHtmlArray', 'hey'),
        ]]];
    }
}
