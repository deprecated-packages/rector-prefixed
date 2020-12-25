<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNonPhpTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureRenameNonPhp', \Rector\Core\ValueObject\StaticNonPhpFileSuffixes::getSuffixRegexPattern());
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Renaming\Rector\Name\RenameClassRector::class => [\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            // Laravel
            'Session' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Session',
            'Form' => '_PhpScoper5edc98a7cce2\\Collective\\Html\\FormFacade',
            'Html' => '_PhpScoper5edc98a7cce2\\Collective\\Html\\HtmlFacade',
        ]]];
    }
}
