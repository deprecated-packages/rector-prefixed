<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.10/reference/types.html#bigint
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Property\ChangeBigIntEntityPropertyToIntTypeRector\ChangeBigIntEntityPropertyToIntTypeRectorTest
 */
final class ChangeBigIntEntityPropertyToIntTypeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrinePropertyAnalyzer
     */
    private $doctrinePropertyAnalyzer;
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    public function __construct(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer $doctrinePropertyAnalyzer, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer)
    {
        $this->doctrinePropertyAnalyzer = $doctrinePropertyAnalyzer;
        $this->docBlockClassRenamer = $docBlockClassRenamer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change database type "bigint" for @var/type declaration to string', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $columnTagValueNode = $this->doctrinePropertyAnalyzer->matchDoctrineColumnTagValueNode($node);
        if ($columnTagValueNode === null) {
            return null;
        }
        if ($columnTagValueNode->getType() !== 'bigint') {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $attributeAwareVarTagValueNode = $phpDocInfo->getVarTagValueNode();
        if ($attributeAwareVarTagValueNode === null) {
            return null;
        }
        $this->docBlockClassRenamer->renamePhpDocTypes($phpDocInfo->getPhpDocNode(), [new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(), new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType()], new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), $node);
        return $node;
    }
}
