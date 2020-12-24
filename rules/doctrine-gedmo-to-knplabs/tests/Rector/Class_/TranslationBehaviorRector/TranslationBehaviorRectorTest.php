<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TranslationBehaviorRector;

use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class TranslationBehaviorRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    public function test() : void
    {
        $fitureFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc');
        $this->doTestFileInfo($fitureFileInfo);
        $this->doTestExtraFile('SomeClassTranslation.php', __DIR__ . '/Source/SomeClassTranslation.php');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector::class;
    }
}
