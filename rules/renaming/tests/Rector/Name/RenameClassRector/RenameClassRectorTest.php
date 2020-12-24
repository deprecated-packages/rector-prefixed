<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Manual\Twig\TwigFilter;
use _PhpScoper2a4e7ab1ecbc\Manual_Twig_Filter;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
     * @see https://github.com/rectorphp/rector/issues/1438
     */
    public function testClassNameDuplication() : void
    {
        $fixtureFileInfo = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureDuplication/skip_duplicated_class.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            'FqnizeNamespaced' => '_PhpScoper2a4e7ab1ecbc\\Abc\\FqnizeNamespaced',
            \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo::class => \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo::class,
            'DateTime' => 'DateTimeInterface',
            'Countable' => 'stdClass',
            \_PhpScoper2a4e7ab1ecbc\Manual_Twig_Filter::class => \_PhpScoper2a4e7ab1ecbc\Manual\Twig\TwigFilter::class,
            'Twig_AbstractManualExtension' => \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension::class,
            'Twig_Extension_Sandbox' => '_PhpScoper2a4e7ab1ecbc\\Twig\\Extension\\SandboxExtension',
            // Renaming class itself and its namespace
            '_PhpScoper2a4e7ab1ecbc\\MyNamespace\\MyClass' => '_PhpScoper2a4e7ab1ecbc\\MyNewNamespace\\MyNewClass',
            '_PhpScoper2a4e7ab1ecbc\\MyNamespace\\MyTrait' => '_PhpScoper2a4e7ab1ecbc\\MyNewNamespace\\MyNewTrait',
            '_PhpScoper2a4e7ab1ecbc\\MyNamespace\\MyInterface' => '_PhpScoper2a4e7ab1ecbc\\MyNewNamespace\\MyNewInterface',
            'MyOldClass' => '_PhpScoper2a4e7ab1ecbc\\MyNamespace\\MyNewClass',
            'AnotherMyOldClass' => 'AnotherMyNewClass',
            '_PhpScoper2a4e7ab1ecbc\\MyNamespace\\AnotherMyClass' => 'MyNewClassWithoutNamespace',
            // test duplicated class - @see https://github.com/rectorphp/rector/issues/1438
            '_PhpScoper2a4e7ab1ecbc\\Rector\\Renaming\\Tests\\Rector\\Name\\RenameClassRector\\Fixture\\SingularClass' => \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass::class,
        ]]];
    }
}
