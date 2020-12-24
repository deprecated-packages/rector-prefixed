<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector;

use Iterator;
use _PhpScoper0a6b37af0871\Nette\Utils\Html;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameStaticMethodRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoper0a6b37af0871\Nette\Utils\Html::class, 'add', \_PhpScoper0a6b37af0871\Nette\Utils\Html::class, 'addHtml'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', '_PhpScoper0a6b37af0871\\Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')]]];
    }
}
