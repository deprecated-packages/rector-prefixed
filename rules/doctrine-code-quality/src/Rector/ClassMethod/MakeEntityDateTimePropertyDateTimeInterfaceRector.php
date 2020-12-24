<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\SetterClassMethodAnalyzer;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeManipulator\PropertyTypeManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see related to maker bundle https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\ClassMethod\MakeEntityDateTimePropertyDateTimeInterfaceRector\MakeEntityDateTimePropertyDateTimeInterfaceRectorTest
 */
final class MakeEntityDateTimePropertyDateTimeInterfaceRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var SetterClassMethodAnalyzer
     */
    private $setterClassMethodAnalyzer;
    /**
     * @var PropertyTypeManipulator
     */
    private $propertyTypeManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeAnalyzer\SetterClassMethodAnalyzer $setterClassMethodAnalyzer, \_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeManipulator\PropertyTypeManipulator $propertyTypeManipulator)
    {
        $this->setterClassMethodAnalyzer = $setterClassMethodAnalyzer;
        $this->propertyTypeManipulator = $propertyTypeManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make maker bundle generate DateTime property accept DateTimeInterface too', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @var DateTime|null
     */
    private $bornAt;

    public function setBornAt(DateTimeInterface $bornAt)
    {
        $this->bornAt = $bornAt;
    }
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
     * @var DateTimeInterface|null
     */
    private $bornAt;

    public function setBornAt(DateTimeInterface $bornAt)
    {
        $this->bornAt = $bornAt;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $property = $this->setterClassMethodAnalyzer->matchDateTimeSetterProperty($node);
        if ($property === null) {
            return null;
        }
        if (!$this->isObjectType($property, 'DateTime')) {
            return null;
        }
        $this->propertyTypeManipulator->changePropertyType($property, 'DateTime', 'DateTimeInterface');
        return $node;
    }
}
