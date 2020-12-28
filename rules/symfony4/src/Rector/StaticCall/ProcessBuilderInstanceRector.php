<?php

declare (strict_types=1);
namespace Rector\Symfony4\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony4\Tests\Rector\StaticCall\ProcessBuilderInstanceRector\ProcessBuilderInstanceRectorTest
 */
final class ProcessBuilderInstanceRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `ProcessBuilder::instance()` to new ProcessBuilder in Process in Symfony. Part of multi-step Rector.', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$processBuilder = Symfony\\Component\\Process\\ProcessBuilder::instance($args);', '$processBuilder = new Symfony\\Component\\Process\\ProcessBuilder($args);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$node->class instanceof \PhpParser\Node\Name) {
            return null;
        }
        if (!$this->isName($node->class, 'Symfony\\Component\\Process\\ProcessBuilder')) {
            return null;
        }
        if (!$this->isName($node->name, 'create')) {
            return null;
        }
        return new \PhpParser\Node\Expr\New_($node->class, $node->args);
    }
}
