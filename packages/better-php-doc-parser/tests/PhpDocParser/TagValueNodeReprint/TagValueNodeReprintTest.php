<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint;

use Iterator;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TagValueNodeReprintTest extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest
{
    /**
     * @dataProvider provideData()
     * @param class-string $tagValueNodeClass
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeClass) : void
    {
        $this->doTestPrintedPhpDocInfo($fileInfo, $tagValueNodeClass);
    }
    public function provideData() : \Iterator
    {
        foreach ($this->getDirectoriesByTagValueNodes() as $tagValueNode => $directory) {
            $filesInDirectory = $this->findFilesFromDirectory($directory);
            foreach ($filesInDirectory as $fileInfos) {
                foreach ($fileInfos as $fileInfo) {
                    (yield [$fileInfo, $tagValueNode]);
                }
            }
        }
    }
    /**
     * @return string[]
     */
    private function getDirectoriesByTagValueNodes() : array
    {
        return [
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => __DIR__ . '/Fixture/Blameable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => __DIR__ . '/Fixture/Gedmo',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => __DIR__ . '/Fixture/AssertChoice',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => __DIR__ . '/Fixture/AssertType',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => __DIR__ . '/Fixture/SymfonyRoute',
            // Doctrine
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => __DIR__ . '/Fixture/DoctrineColumn',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode::class => __DIR__ . '/Fixture/DoctrineJoinTable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => __DIR__ . '/Fixture/DoctrineEntity',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode::class => __DIR__ . '/Fixture/DoctrineTable',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => __DIR__ . '/Fixture/DoctrineCustomIdGenerator',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => __DIR__ . '/Fixture/DoctrineGeneratedValue',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => __DIR__ . '/Fixture/DoctrineEmbedded',
            // special case
            \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class => __DIR__ . '/Fixture/ConstantReference',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => __DIR__ . '/Fixture/SensioTemplate',
            \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => __DIR__ . '/Fixture/SensioMethod',
            \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::class => __DIR__ . '/Fixture/Native/Template',
            \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class => __DIR__ . '/Fixture/Native/VarTag',
        ];
    }
}
