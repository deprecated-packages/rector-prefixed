<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\LNumber;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\FuncCall\RandomFunctionRector\RandomFunctionRectorTest
 */
final class RandomFunctionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_FUNCTION_NAMES = ['getrandmax' => 'mt_getrandmax', 'srand' => 'mt_srand', 'mt_rand' => 'random_int', 'rand' => 'random_int'];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes rand, srand and getrandmax by new mt_* alternatives.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('rand();', 'mt_rand();')]);
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
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::CSPRNG_FUNCTIONS)) {
            return null;
        }
        foreach (self::OLD_TO_NEW_FUNCTION_NAMES as $oldFunctionName => $newFunctionName) {
            if ($this->isName($node, $oldFunctionName)) {
                $node->name = new \PhpParser\Node\Name($newFunctionName);
                // special case: random_int(); → random_int(0, getrandmax());
                if ($newFunctionName === 'random_int' && $node->args === []) {
                    $node->args[0] = new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\LNumber(0));
                    $node->args[1] = new \PhpParser\Node\Arg($this->nodeFactory->createFuncCall('mt_getrandmax'));
                }
                return $node;
            }
        }
        return $node;
    }
}
