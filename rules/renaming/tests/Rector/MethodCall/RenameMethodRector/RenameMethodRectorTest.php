<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector;

use Iterator;
use RectorPrefix20201229\Nette\Utils\Html;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename;
use Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201229\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class => [\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => [
            new \Rector\Renaming\ValueObject\MethodCallRename(\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
            new \Rector\Renaming\ValueObject\MethodCallRename(\RectorPrefix20201229\Nette\Utils\Html::class, 'add', 'addHtml'),
            new \Rector\Renaming\ValueObject\MethodCallRename('*Presenter', 'run', '__invoke'),
            new \Rector\Renaming\ValueObject\MethodCallRename(\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename::class, 'preventPHPStormRefactoring', 'gone'),
            // with array key
            new \Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(\RectorPrefix20201229\Nette\Utils\Html::class, 'addToArray', 'addToHtmlArray', 'hey'),
        ]]];
    }
}
