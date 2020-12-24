<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassConst;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\ChangeConstantVisibilityRectorTest
 */
final class ChangeConstantVisibilityRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_CONSTANT_VISIBILITY_CHANGES = 'class_constant_visibility_changes';
    /**
     * @var ClassConstantVisibilityChange[]
     */
    private $classConstantVisibilityChanges = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change visibility of constant from parent class.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class FrameworkClass
{
    protected const SOME_CONSTANT = 1;
}

class MyClass extends FrameworkClass
{
    public const SOME_CONSTANT = 1;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class FrameworkClass
{
    protected const SOME_CONSTANT = 1;
}

class MyClass extends FrameworkClass
{
    protected const SOME_CONSTANT = 1;
}
CODE_SAMPLE
, [self::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange('ParentObject', 'SOME_CONSTANT', 'protected')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassConst $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->classConstantVisibilityChanges as $classConstantVisibilityChange) {
            if (!$this->isObjectType($node, $classConstantVisibilityChange->getClass())) {
                continue;
            }
            if (!$this->isName($node, $classConstantVisibilityChange->getConstant())) {
                continue;
            }
            $this->changeNodeVisibility($node, $classConstantVisibilityChange->getVisibility());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $classConstantVisibilityChanges = $configuration[self::CLASS_CONSTANT_VISIBILITY_CHANGES] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($classConstantVisibilityChanges, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ClassConstantVisibilityChange::class);
        $this->classConstantVisibilityChanges = $classConstantVisibilityChanges;
    }
}
