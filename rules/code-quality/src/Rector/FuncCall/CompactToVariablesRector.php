<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use Rector\CodeQuality\CompactConverter;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/a/16319909/1348344
 * @see https://3v4l.org/8GJEs
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\CompactToVariablesRector\CompactToVariablesRectorTest
 */
final class CompactToVariablesRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var CompactConverter
     */
    private $compactConverter;
    public function __construct(\Rector\CodeQuality\CompactConverter $compactConverter)
    {
        $this->compactConverter = $compactConverter;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change compact() call to own array', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $checkout = 'one';
        $form = 'two';

        return compact('checkout', 'form');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $checkout = 'one';
        $form = 'two';

        return ['checkout' => $checkout, 'form' => $form];
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
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, 'compact')) {
            return null;
        }
        if (!$this->compactConverter->hasAllArgumentsNamed($node)) {
            return null;
        }
        return $this->compactConverter->convertToArray($node);
    }
}
