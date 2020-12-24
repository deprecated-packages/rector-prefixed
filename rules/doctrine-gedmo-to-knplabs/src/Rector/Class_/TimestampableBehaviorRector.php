<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineGedmoToKnplabs\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/timestampable.md
 * @see https://github.com/KnpLabs/DoctrineBehaviors/blob/4e0677379dd4adf84178f662d08454a9627781a8/docs/timestampable.md
 *
 * @see \Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TimestampableBehaviorRector\TimestampableBehaviorRectorTest
 */
final class TimestampableBehaviorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator)
    {
        $this->classManipulator = $classManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change Timestampable from gedmo/doctrine-extensions to knplabs/doctrine-behaviors', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Gedmo\Timestampable\Traits\TimestampableEntity;

class SomeClass
{
    use TimestampableEntity;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;

class SomeClass implements TimestampableInterface
{
    use TimestampableTrait;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->classManipulator->hasTrait($node, '_PhpScoper0a6b37af0871\\Gedmo\\Timestampable\\Traits\\TimestampableEntity')) {
            return null;
        }
        $this->classManipulator->replaceTrait($node, '_PhpScoper0a6b37af0871\\Gedmo\\Timestampable\\Traits\\TimestampableEntity', '_PhpScoper0a6b37af0871\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait');
        $node->implements[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface');
        return $node;
    }
}
