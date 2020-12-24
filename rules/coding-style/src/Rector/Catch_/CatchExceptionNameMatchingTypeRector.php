<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\Catch_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Catch_\CatchExceptionNameMatchingTypeRector\CatchExceptionNameMatchingTypeRectorTest
 */
final class CatchExceptionNameMatchingTypeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/xmfMAX/1
     */
    private const STARTS_WITH_ABBREVIATION_REGEX = '#^([A-Za-z]+?)([A-Z]{1}[a-z]{1})([A-Za-z]*)#';
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Type and name of catch exception should match', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        try {
            // ...
        } catch (SomeException $typoException) {
            $typoException->getMessage();
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        try {
            // ...
        } catch (SomeException $someException) {
            $someException->getMessage();
        }
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_::class];
    }
    /**
     * @param Catch_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (\count((array) $node->types) !== 1) {
            return null;
        }
        if ($node->var === null) {
            return null;
        }
        $oldVariableName = $this->getName($node->var);
        if (!$oldVariableName) {
            return null;
        }
        $type = $node->types[0];
        $typeShortName = $this->getShortName($type);
        $newVariableName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace(\lcfirst($typeShortName), self::STARTS_WITH_ABBREVIATION_REGEX, function (array $matches) : string {
            $output = '';
            $output .= isset($matches[1]) ? \strtolower($matches[1]) : '';
            $output .= $matches[2] ?? '';
            $output .= $matches[3] ?? '';
            return $output;
        });
        if ($oldVariableName === $newVariableName) {
            return null;
        }
        $newVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($newVariableName);
        $isFoundInPrevious = (bool) $this->betterNodeFinder->findFirstPrevious($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $n) use($newVariable) : bool {
            return $this->areNodesEqual($n, $newVariable);
        });
        if ($isFoundInPrevious) {
            return null;
        }
        $node->var->name = $newVariableName;
        $this->renameVariableInStmts($node, $oldVariableName, $newVariableName);
        return $node;
    }
    private function renameVariableInStmts(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_ $catch, string $oldVariableName, string $newVariableName) : void
    {
        $this->traverseNodesWithCallable($catch->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($oldVariableName, $newVariableName) : void {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return;
            }
            if (!$this->isVariableName($node, $oldVariableName)) {
                return;
            }
            $node->name = $newVariableName;
        });
    }
}
