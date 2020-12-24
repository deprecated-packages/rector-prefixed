<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Rector\Variable;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\Php\ReservedKeywordAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Variable\UnderscoreToCamelCaseLocalVariableNameRector\UnderscoreToCamelCaseLocalVariableNameRectorTest
 */
final class UnderscoreToCamelCaseLocalVariableNameRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReservedKeywordAnalyzer
     */
    private $reservedKeywordAnalyzer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score local variable names to camelCase', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $nodeName = $this->getName($node);
        if ($nodeName === null) {
            return null;
        }
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($nodeName, '_')) {
            return null;
        }
        if ($this->reservedKeywordAnalyzer->isNativeVariable($nodeName)) {
            return null;
        }
        $camelCaseName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($nodeName);
        if ($camelCaseName === 'this' || $camelCaseName === '' || \is_numeric($camelCaseName[0])) {
            return null;
        }
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr && $this->isFoundInParentNode($node)) {
            return null;
        }
        if (($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg || $parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param || $parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt) && $this->isFoundInParentNode($node)) {
            return null;
        }
        if ($this->isFoundInPreviousNode($node)) {
            return null;
        }
        $node->name = $camelCaseName;
        return $node;
    }
    private function isFoundInParentNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var ClassMethod|Function_|null $classMethodOrFunction */
        $classMethodOrFunction = $this->betterNodeFinder->findFirstParentInstanceOf($variable, [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_::class]);
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
    private function isFoundInPreviousNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $previousNode = $variable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$previousNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return \false;
        }
        return $this->isFoundInParentNode($variable);
    }
}
