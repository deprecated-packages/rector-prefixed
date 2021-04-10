<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\Break_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeNestingScope\ContextAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://stackoverflow.com/questions/3618030/php-fatal-error-cannot-break-continue https://stackoverflow.com/questions/11988281/why-does-cannot-break-continue-1-level-comes-in-php
 *
 * @see https://3v4l.org/Qtelt
 * @see \Rector\Tests\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector\BreakNotInLoopOrSwitchToReturnRectorTest
 */
final class BreakNotInLoopOrSwitchToReturnRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ContextAnalyzer
     */
    private $contextAnalyzer;
    public function __construct(\Rector\NodeNestingScope\ContextAnalyzer $contextAnalyzer)
    {
        $this->contextAnalyzer = $contextAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert break outside for/foreach/switch context to return', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($isphp5)
            return 1;
        else
            return 2;
        break;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($isphp5)
            return 1;
        else
            return 2;
        return;
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
        return [\PhpParser\Node\Stmt\Break_::class];
    }
    /**
     * @param Break_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->contextAnalyzer->isInLoop($node)) {
            return null;
        }
        if ($this->contextAnalyzer->isInIf($node)) {
            return new \PhpParser\Node\Stmt\Return_();
        }
        $this->removeNode($node);
        return $node;
    }
}
