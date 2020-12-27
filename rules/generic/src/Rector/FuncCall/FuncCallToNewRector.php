<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\FuncCall\FuncCallToNewRector\FuncCallToNewRectorTest
 */
final class FuncCallToNewRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNCTION_TO_NEW = '$functionToNew';
    /**
     * @var string[]
     */
    private $functionToNew = [];
    public function getRuleDefinition() : \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change configured function calls to new Instance', [new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $array = collection([]);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $array = new \Collection([]);
    }
}
CODE_SAMPLE
, [self::FUNCTION_TO_NEW => ['collection' => ['Collection']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->functionToNew as $function => $new) {
            if (!$this->isName($node, $function)) {
                continue;
            }
            return new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified($new), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->functionToNew = $configuration[self::FUNCTION_TO_NEW] ?? [];
    }
}
