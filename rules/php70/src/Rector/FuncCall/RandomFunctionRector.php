<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\FuncCall\RandomFunctionRector\RandomFunctionRectorTest
 */
final class RandomFunctionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_FUNCTION_NAMES = ['getrandmax' => 'mt_getrandmax', 'srand' => 'mt_srand', 'mt_rand' => 'random_int', 'rand' => 'random_int'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes rand, srand and getrandmax by new mt_* alternatives.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('rand();', 'mt_rand();')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::CSPRNG_FUNCTIONS)) {
            return null;
        }
        foreach (self::OLD_TO_NEW_FUNCTION_NAMES as $oldFunctionName => $newFunctionName) {
            if ($this->isName($node, $oldFunctionName)) {
                $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newFunctionName);
                // special case: random_int(); → random_int(0, getrandmax());
                if ($newFunctionName === 'random_int' && $node->args === []) {
                    $node->args[0] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber(0));
                    $node->args[1] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($this->createFuncCall('mt_getrandmax'));
                }
                return $node;
            }
        }
        return $node;
    }
}
