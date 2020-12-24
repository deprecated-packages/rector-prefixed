<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Rector\Variable;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Php\ReservedKeywordAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Variable\UnderscoreToCamelCaseLocalVariableNameRector\UnderscoreToCamelCaseLocalVariableNameRectorTest
 */
final class UnderscoreToCamelCaseLocalVariableNameRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReservedKeywordAnalyzer
     */
    private $reservedKeywordAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score local variable names to camelCase', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($a_b)
    {
        $some_value = $a_b;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($a_b)
    {
        $someValue = $a_b;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $nodeName = $this->getName($node);
        if ($nodeName === null) {
            return null;
        }
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($nodeName, '_')) {
            return null;
        }
        if ($this->reservedKeywordAnalyzer->isNativeVariable($nodeName)) {
            return null;
        }
        $camelCaseName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($nodeName);
        if ($camelCaseName === 'this' || $camelCaseName === '' || \is_numeric($camelCaseName[0])) {
            return null;
        }
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr && $this->isFoundInParentNode($node)) {
            return null;
        }
        if (($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg || $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param || $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt) && $this->isFoundInParentNode($node)) {
            return null;
        }
        if ($this->isFoundInPreviousNode($node)) {
            return null;
        }
        $node->name = $camelCaseName;
        return $node;
    }
    private function isFoundInParentNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var ClassMethod|Function_|null $classMethodOrFunction */
        $classMethodOrFunction = $this->betterNodeFinder->findFirstParentInstanceOf($variable, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class]);
        if ($classMethodOrFunction === null) {
            return \false;
        }
        /** @var Param[] $params */
        $params = (array) $classMethodOrFunction->getParams();
        foreach ($params as $param) {
            if ($this->areNamesEqual($param->var, $variable)) {
                return \true;
            }
        }
        return \false;
    }
    private function isFoundInPreviousNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $previousNode = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$previousNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return \false;
        }
        return $this->isFoundInParentNode($variable);
    }
}
