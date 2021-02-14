<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
use RectorPrefix20210214\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
/**
 * Replaces:
 *
 * if (...) {
 *    $this->template->key = 'some';
 * } else {
 *    $this->template->key = 'another';
 * }
 *
 * ↓
 *
 * if (...) {
 *    $key = 'some';
 * } else {
 *    $key = 'another';
 * }
 */
final class ConditionalTemplateAssignReplacer
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\RectorPrefix20210214\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function processClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use($magicTemplatePropertyCalls) : ?Assign {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            $variableName = $this->matchConditionalAssignVariableName($node, $magicTemplatePropertyCalls->getConditionalAssigns());
            if ($variableName === null) {
                return null;
            }
            return new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable($variableName), $node->expr);
        });
    }
    /**
     * @param array<string, Assign[]> $conditionalAssignsByName
     */
    private function matchConditionalAssignVariableName(\PhpParser\Node\Expr\Assign $assign, array $conditionalAssignsByName) : ?string
    {
        foreach ($conditionalAssignsByName as $name => $conditionalAssigns) {
            if (!$this->betterStandardPrinter->isNodeEqual($assign, $conditionalAssigns)) {
                continue;
            }
            return $name;
        }
        return null;
    }
}
