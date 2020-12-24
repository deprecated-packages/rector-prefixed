<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint;

use Iterator;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class TagValueNodeReprintTest extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest
{
    /**
     * @dataProvider provideData()
     * @param class-string $tagValueNodeClass
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeClass) : void
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
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => __DIR__ . '/Fixture/Blameable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => __DIR__ . '/Fixture/Gedmo',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => __DIR__ . '/Fixture/AssertChoice',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => __DIR__ . '/Fixture/AssertType',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => __DIR__ . '/Fixture/SymfonyRoute',
            // Doctrine
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => __DIR__ . '/Fixture/DoctrineColumn',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode::class => __DIR__ . '/Fixture/DoctrineJoinTable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => __DIR__ . '/Fixture/DoctrineEntity',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode::class => __DIR__ . '/Fixture/DoctrineTable',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => __DIR__ . '/Fixture/DoctrineCustomIdGenerator',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => __DIR__ . '/Fixture/DoctrineGeneratedValue',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => __DIR__ . '/Fixture/DoctrineEmbedded',
            // special case
            \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class => __DIR__ . '/Fixture/ConstantReference',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => __DIR__ . '/Fixture/SensioTemplate',
            \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => __DIR__ . '/Fixture/SensioMethod',
            \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::class => __DIR__ . '/Fixture/Native/Template',
            \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class => __DIR__ . '/Fixture/Native/VarTag',
        ];
    }
}
