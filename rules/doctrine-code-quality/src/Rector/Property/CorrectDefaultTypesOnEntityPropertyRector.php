<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Property;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Property\CorrectDefaultTypesOnEntityPropertyRector\CorrectDefaultTypesOnEntityPropertyRectorTest
 */
final class CorrectDefaultTypesOnEntityPropertyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrinePropertyAnalyzer
     */
    private $doctrinePropertyAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\NodeAnalyzer\DoctrinePropertyAnalyzer $doctrinePropertyAnalyzer)
    {
        $this->doctrinePropertyAnalyzer = $doctrinePropertyAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change default value types to match Doctrine annotation type', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Column(name="is_old", type="boolean")
     */
    private $isOld = '0';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Column(name="is_old", type="boolean")
     */
    private $isOld = false;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $columnTagValueNode = $this->doctrinePropertyAnalyzer->matchDoctrineColumnTagValueNode($node);
        if ($columnTagValueNode === null) {
            return null;
        }
        $onlyProperty = $node->props[0];
        $defaultValue = $onlyProperty->default;
        if ($defaultValue === null) {
            return null;
        }
        if (\in_array($columnTagValueNode->getType(), ['bool', 'boolean'], \true)) {
            return $this->refactorToBoolType($onlyProperty, $node);
        }
        if (\in_array($columnTagValueNode->getType(), ['int', 'integer', 'bigint', 'smallint'], \true)) {
            return $this->refactorToIntType($onlyProperty, $node);
        }
        return null;
    }
    private function refactorToBoolType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty $propertyProperty, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        if ($propertyProperty->default === null) {
            return null;
        }
        $defaultExpr = $propertyProperty->default;
        if ($defaultExpr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            $propertyProperty->default = \boolval($defaultExpr->value) ? $this->createTrue() : $this->createFalse();
            return $property;
        }
        if ($defaultExpr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch) {
            // already ok
            return null;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException();
    }
    private function refactorToIntType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty $propertyProperty, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        if ($propertyProperty->default === null) {
            return null;
        }
        $defaultExpr = $propertyProperty->default;
        if ($defaultExpr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            $propertyProperty->default = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber((int) $defaultExpr->value);
            return $property;
        }
        if ($defaultExpr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber) {
            // already correct
            return null;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException();
    }
}
