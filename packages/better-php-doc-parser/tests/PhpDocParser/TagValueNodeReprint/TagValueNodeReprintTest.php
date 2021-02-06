<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint;

use Iterator;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
use RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo;
final class TagValueNodeReprintTest extends \Rector\BetterPhpDocParser\Tests\PhpDocParser\AbstractPhpDocInfoTest
{
    /**
     * @dataProvider provideData()
     * @param class-string $tagValueNodeClass
     */
    public function test(\RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $tagValueNodeClass) : void
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
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => __DIR__ . '/Fixture/Blameable',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => __DIR__ . '/Fixture/Gedmo',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => __DIR__ . '/Fixture/AssertChoice',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => __DIR__ . '/Fixture/AssertType',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => __DIR__ . '/Fixture/SymfonyRoute',
            // Doctrine
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => __DIR__ . '/Fixture/DoctrineColumn',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode::class => __DIR__ . '/Fixture/DoctrineJoinTable',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => __DIR__ . '/Fixture/DoctrineEntity',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode::class => __DIR__ . '/Fixture/DoctrineTable',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => __DIR__ . '/Fixture/DoctrineCustomIdGenerator',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => __DIR__ . '/Fixture/DoctrineGeneratedValue',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => __DIR__ . '/Fixture/DoctrineEmbedded',
            // special case
            \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class => __DIR__ . '/Fixture/ConstantReference',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => __DIR__ . '/Fixture/SensioTemplate',
            \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => __DIR__ . '/Fixture/SensioMethod',
            \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::class => __DIR__ . '/Fixture/Native/Template',
            \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class => __DIR__ . '/Fixture/Native/VarTag',
        ];
    }
}
