<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector;

use Iterator;
use _PhpScopere8e811afab72\Nette\Utils\Html;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => [
            new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
            new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScopere8e811afab72\Nette\Utils\Html::class, 'add', 'addHtml'),
            new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('*Presenter', 'run', '__invoke'),
            new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename::class, 'preventPHPStormRefactoring', 'gone'),
            // with array key
            new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(\_PhpScopere8e811afab72\Nette\Utils\Html::class, 'addToArray', 'addToHtmlArray', 'hey'),
        ]]];
    }
}
