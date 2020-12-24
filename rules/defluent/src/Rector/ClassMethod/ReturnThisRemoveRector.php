<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Defluent\ConflictGuard\ParentClassMethodTypeOverrideGuard;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Defluent\Tests\Rector\ClassMethod\ReturnThisRemoveRector\ReturnThisRemoveRectorTest
 */
final class ReturnThisRemoveRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ParentClassMethodTypeOverrideGuard
     */
    private $parentClassMethodTypeOverrideGuard;
    public function __construct(\_PhpScopere8e811afab72\Rector\Defluent\ConflictGuard\ParentClassMethodTypeOverrideGuard $parentClassMethodTypeOverrideGuard)
    {
        $this->parentClassMethodTypeOverrideGuard = $parentClassMethodTypeOverrideGuard;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes "return $this;" from *fluent interfaces* for specified classes.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeExampleClass
{
    public function someFunction()
    {
        return $this;
    }

    public function otherFunction()
    {
        return $this;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeExampleClass
{
    public function someFunction()
    {
    }

    public function otherFunction()
    {
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
        $returnThis = $this->matchSingleReturnThis($node);
        if ($returnThis === null) {
            return null;
        }
        if ($this->shouldSkip($returnThis, $node)) {
            return null;
        }
        $this->removeNode($returnThis);
        $classMethod = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        if ($this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::VOID_TYPE)) {
            $classMethod->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('void');
        }
        $this->removePhpDocTagValueNode($classMethod, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        return null;
    }
    /**
     * Matches only 1st level "return $this;"
     */
    private function matchSingleReturnThis(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_
    {
        /** @var Return_[] $returns */
        $returns = $this->betterNodeFinder->findInstanceOf($classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_::class);
        // can be only 1 return
        if (\count($returns) !== 1) {
            return null;
        }
        $return = $returns[0];
        if ($return->expr === null) {
            return null;
        }
        if (!$this->isVariableName($return->expr, 'this')) {
            return null;
        }
        $parentNode = $return->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode !== $classMethod) {
            return null;
        }
        return $return;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->parentClassMethodTypeOverrideGuard->isReturnTypeChangeAllowed($classMethod)) {
            return \true;
        }
        if ($return->expr === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return \false;
    }
}
