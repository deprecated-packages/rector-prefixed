<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector;

use Iterator;
use RectorPrefix2020DecSat\Nette\Utils\Html;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RenameStaticMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class => [\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => [new \Rector\Renaming\ValueObject\RenameStaticMethod(\RectorPrefix2020DecSat\Nette\Utils\Html::class, 'add', \RectorPrefix2020DecSat\Nette\Utils\Html::class, 'addHtml'), new \Rector\Renaming\ValueObject\RenameStaticMethod(\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', 'RectorPrefix2020DecSat\\Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')]]];
    }
}
