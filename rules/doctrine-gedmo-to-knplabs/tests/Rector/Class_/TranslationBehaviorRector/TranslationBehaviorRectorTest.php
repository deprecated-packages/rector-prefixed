<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TranslationBehaviorRector;

use _PhpScopere8e811afab72\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TranslationBehaviorRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    public function test() : void
    {
        $fitureFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc');
        $this->doTestFileInfo($fitureFileInfo);
        $this->doTestExtraFile('SomeClassTranslation.php', __DIR__ . '/Source/SomeClassTranslation.php');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector::class;
    }
}
