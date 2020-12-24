<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony5\Rector\New_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#propertyaccess
 * @see \Rector\Symfony5\Tests\Rector\New_\PropertyAccessorCreationBooleanToFlagsRector\PropertyAccessorCreationBooleanToFlagsRectorTest
 */
final class PropertyAccessorCreationBooleanToFlagsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes first argument of PropertyAccessor::__construct() to flags from boolean', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $propertyAccessor = new PropertyAccessor(true);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $propertyAccessor = new PropertyAccessor(PropertyAccessor::MAGIC_CALL | PropertyAccessor::MAGIC_GET | PropertyAccessor::MAGIC_SET);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $isTrue = $this->isTrue($node->args[0]->value);
        $bitwiseOr = $this->prepareFlags($isTrue);
        $node->args[0] = $this->createArg($bitwiseOr);
        return $node;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : bool
    {
        if (!$new->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return \true;
        }
        if (!$this->isName($new->class, '_PhpScopere8e811afab72\\Symfony\\Component\\PropertyAccess\\PropertyAccessor')) {
            return \true;
        }
        return !$this->isBool($new->args[0]->value);
    }
    private function prepareFlags(bool $currentValue) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr
    {
        $classConstFetch = $this->createClassConstFetch('_PhpScopere8e811afab72\\Symfony\\Component\\PropertyAccess\\PropertyAccessor', 'MAGIC_GET');
        $magicSet = $this->createClassConstFetch('_PhpScopere8e811afab72\\Symfony\\Component\\PropertyAccess\\PropertyAccessor', 'MAGIC_SET');
        if (!$currentValue) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr($classConstFetch, $magicSet);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr($this->createClassConstFetch('_PhpScopere8e811afab72\\Symfony\\Component\\PropertyAccess\\PropertyAccessor', 'MAGIC_CALL'), $classConstFetch), $magicSet);
    }
}
