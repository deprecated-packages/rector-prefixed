<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PhpDeglobalize\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Global_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/DWC4P
 *
 * @see https://stackoverflow.com/a/12446305/1348344
 * @see \Rector\PhpDeglobalize\Tests\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector\ChangeGlobalVariablesToPropertiesRectorTest
 */
final class ChangeGlobalVariablesToPropertiesRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $globalVariableNames = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change global $variables to private properties', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function go()
    {
        global $variable;
        $variable = 5;
    }

    public function run()
    {
        global $variable;
        var_dump($variable);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    private $variable;
    public function go()
    {
        $this->variable = 5;
    }

    public function run()
    {
        var_dump($this->variable);
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $this->collectGlobalVariableNamesAndRefactorToPropertyFetch($node);
        foreach ($this->globalVariableNames as $globalVariableName) {
            $this->addPropertyToClass($classLike, null, $globalVariableName);
        }
        return $node;
    }
    private function collectGlobalVariableNamesAndRefactorToPropertyFetch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->globalVariableNames = [];
        $this->traverseNodesWithCallable($classMethod, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?PropertyFetch {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Global_) {
                $this->refactorGlobal($node);
                return null;
            }
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return $this->refactorGlobalVariable($node);
            }
            return null;
        });
    }
    private function refactorGlobal(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Global_ $global) : void
    {
        foreach ($global->vars as $var) {
            $varName = $this->getName($var);
            if ($varName === null) {
                return;
            }
            $this->globalVariableNames[] = $varName;
        }
        $this->removeNode($global);
    }
    private function refactorGlobalVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch
    {
        if (!$this->isNames($variable, $this->globalVariableNames)) {
            return null;
        }
        // replace with property fetch
        $variableName = $this->getName($variable);
        if ($variableName === null) {
            return null;
        }
        return $this->createPropertyFetch('this', $variableName);
    }
}
