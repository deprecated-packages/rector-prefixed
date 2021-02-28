<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\Variable;

use RectorPrefix20210228\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\Core\Php\ReservedKeywordAnalyzer;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Variable\UnderscoreToCamelCaseLocalVariableNameRector\UnderscoreToCamelCaseLocalVariableNameRectorTest
 */
final class UnderscoreToCamelCaseLocalVariableNameRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReservedKeywordAnalyzer
     */
    private $reservedKeywordAnalyzer;
    public function __construct(\Rector\Core\Php\ReservedKeywordAnalyzer $reservedKeywordAnalyzer)
    {
        $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score local variable names to camelCase', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $nodeName = $this->getName($node);
        if ($nodeName === null) {
            return null;
        }
        if (!\RectorPrefix20210228\Nette\Utils\Strings::contains($nodeName, '_')) {
            return null;
        }
        if ($this->reservedKeywordAnalyzer->isNativeVariable($nodeName)) {
            return null;
        }
        $camelCaseName = \Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($nodeName);
        if ($this->isReserved($camelCaseName)) {
            return null;
        }
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Expr && $this->isFoundInParentNode($node)) {
            return null;
        }
        if (($parentNode instanceof \PhpParser\Node\Arg || $parentNode instanceof \PhpParser\Node\Param || $parentNode instanceof \PhpParser\Node\Stmt) && $this->isFoundInParentNode($node)) {
            return null;
        }
        if ($this->isFoundInPreviousNode($node)) {
            return null;
        }
        $node->name = $camelCaseName;
        return $node;
    }
    private function isReserved(string $string) : bool
    {
        if ($string === 'this') {
            return \true;
        }
        if ($string === '') {
            return \true;
        }
        return \is_numeric($string[0]);
    }
    private function isFoundInParentNode(\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var ClassMethod|Function_|null $classMethodOrFunction */
        $classMethodOrFunction = $this->betterNodeFinder->findParentTypes($variable, [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Function_::class]);
        if ($classMethodOrFunction === null) {
            return \false;
        }
        /** @var Param[] $params */
        $params = $classMethodOrFunction->getParams();
        foreach ($params as $param) {
            if ($this->areNamesEqual($param->var, $variable)) {
                return \true;
            }
        }
        return \false;
    }
    private function isFoundInPreviousNode(\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $previousNode = $variable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$previousNode instanceof \PhpParser\Node\Expr) {
            return \false;
        }
        return $this->isFoundInParentNode($variable);
    }
}
