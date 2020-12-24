<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoperb75b35f52b74\Manual\Twig\TwigFilter;
use _PhpScoperb75b35f52b74\Manual_Twig_Filter;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
     * @see https://github.com/rectorphp/rector/issues/1438
     */
    public function testClassNameDuplication() : void
    {
        $fixtureFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureDuplication/skip_duplicated_class.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            'FqnizeNamespaced' => '_PhpScoperb75b35f52b74\\Abc\\FqnizeNamespaced',
            \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo::class => \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo::class,
            'DateTime' => 'DateTimeInterface',
            'Countable' => 'stdClass',
            \_PhpScoperb75b35f52b74\Manual_Twig_Filter::class => \_PhpScoperb75b35f52b74\Manual\Twig\TwigFilter::class,
            'Twig_AbstractManualExtension' => \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension::class,
            'Twig_Extension_Sandbox' => '_PhpScoperb75b35f52b74\\Twig\\Extension\\SandboxExtension',
            // Renaming class itself and its namespace
            '_PhpScoperb75b35f52b74\\MyNamespace\\MyClass' => '_PhpScoperb75b35f52b74\\MyNewNamespace\\MyNewClass',
            '_PhpScoperb75b35f52b74\\MyNamespace\\MyTrait' => '_PhpScoperb75b35f52b74\\MyNewNamespace\\MyNewTrait',
            '_PhpScoperb75b35f52b74\\MyNamespace\\MyInterface' => '_PhpScoperb75b35f52b74\\MyNewNamespace\\MyNewInterface',
            'MyOldClass' => '_PhpScoperb75b35f52b74\\MyNamespace\\MyNewClass',
            'AnotherMyOldClass' => 'AnotherMyNewClass',
            '_PhpScoperb75b35f52b74\\MyNamespace\\AnotherMyClass' => 'MyNewClassWithoutNamespace',
            // test duplicated class - @see https://github.com/rectorphp/rector/issues/1438
            '_PhpScoperb75b35f52b74\\Rector\\Renaming\\Tests\\Rector\\Name\\RenameClassRector\\Fixture\\SingularClass' => \_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass::class,
        ]]];
    }
}
