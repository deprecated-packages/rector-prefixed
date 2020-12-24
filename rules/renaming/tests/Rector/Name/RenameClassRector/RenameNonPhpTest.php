<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNonPhpTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureRenameNonPhp', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\StaticNonPhpFileSuffixes::getSuffixRegexPattern());
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            // Laravel
            'Session' => '_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Session',
            'Form' => '_PhpScoperb75b35f52b74\\Collective\\Html\\FormFacade',
            'Html' => '_PhpScoperb75b35f52b74\\Collective\\Html\\HtmlFacade',
        ]]];
    }
}
