<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TranslationBehaviorRector;

use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class TranslationBehaviorRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    public function test() : void
    {
        $fitureFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc');
        $this->doTestFileInfo($fitureFileInfo);
        $this->doTestExtraFile('SomeClassTranslation.php', __DIR__ . '/Source/SomeClassTranslation.php');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector::class;
    }
}
