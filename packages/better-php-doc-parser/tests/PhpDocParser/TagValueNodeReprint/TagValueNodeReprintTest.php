<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint;

use Iterator;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class TagValueNodeReprintTest extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest
{
    /**
     * @dataProvider provideData()
     * @param class-string $tagValueNodeClass
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeClass) : void
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
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => __DIR__ . '/Fixture/Blameable',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => __DIR__ . '/Fixture/Gedmo',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => __DIR__ . '/Fixture/AssertChoice',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => __DIR__ . '/Fixture/AssertType',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => __DIR__ . '/Fixture/SymfonyRoute',
            // Doctrine
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => __DIR__ . '/Fixture/DoctrineColumn',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode::class => __DIR__ . '/Fixture/DoctrineJoinTable',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => __DIR__ . '/Fixture/DoctrineEntity',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode::class => __DIR__ . '/Fixture/DoctrineTable',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => __DIR__ . '/Fixture/DoctrineCustomIdGenerator',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => __DIR__ . '/Fixture/DoctrineGeneratedValue',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => __DIR__ . '/Fixture/DoctrineEmbedded',
            // special case
            \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class => __DIR__ . '/Fixture/ConstantReference',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => __DIR__ . '/Fixture/SensioTemplate',
            \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => __DIR__ . '/Fixture/SensioMethod',
            \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::class => __DIR__ . '/Fixture/Native/Template',
            \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class => __DIR__ . '/Fixture/Native/VarTag',
        ];
    }
}
