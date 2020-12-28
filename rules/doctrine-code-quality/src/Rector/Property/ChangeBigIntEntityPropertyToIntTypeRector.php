<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.10/reference/types.html#bigint
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector\ChangeBigIntEntityPropertyToIntTypeRectorTest
 */
final class ChangeBigIntEntityPropertyToIntTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrinePropertyAnalyzer
     */
    private $doctrinePropertyAnalyzer;
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    public function __construct(\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer $doctrinePropertyAnalyzer, \Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer)
    {
        $this->doctrinePropertyAnalyzer = $doctrinePropertyAnalyzer;
        $this->docBlockClassRenamer = $docBlockClassRenamer;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change database type "bigint" for @var/type declaration to string', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SomeEntity
{
    /**
     * @var int|null
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $bigNumber;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SomeEntity
{
    /**
     * @var string|null
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $bigNumber;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $columnTagValueNode = $this->doctrinePropertyAnalyzer->matchDoctrineColumnTagValueNode($node);
        if ($columnTagValueNode === null) {
            return null;
        }
        if ($columnTagValueNode->getType() !== 'bigint') {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $attributeAwareVarTagValueNode = $phpDocInfo->getVarTagValueNode();
        if ($attributeAwareVarTagValueNode === null) {
            return null;
        }
        $this->docBlockClassRenamer->renamePhpDocTypes($phpDocInfo->getPhpDocNode(), [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\BooleanType()], new \PHPStan\Type\StringType(), $node);
        return $node;
    }
}
