<?php

declare (strict_types=1);
namespace Rector\Removing\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeRemoval\BreakingRemovalGuard;
use Rector\Removing\ValueObject\RemoveFuncCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210422\Webmozart\Assert\Assert;
/**
 * @see \Rector\Tests\Removing\Rector\FuncCall\RemoveFuncCallRector\RemoveFuncCallRectorTest
 */
final class RemoveFuncCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    const REMOVE_FUNC_CALLS = 'remove_func_calls';
    /**
     * @var RemoveFuncCall[]
     */
    private $removeFuncCalls = [];
    /**
     * @var BreakingRemovalGuard
     */
    private $breakingRemovalGuard;
    public function __construct(\Rector\NodeRemoval\BreakingRemovalGuard $breakingRemovalGuard)
    {
        $this->breakingRemovalGuard = $breakingRemovalGuard;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::REMOVE_FUNC_CALLS => [new \Rector\Removing\ValueObject\RemoveFuncCall('ini_get', [1 => ['y2k_compliance']])]];
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove ini_get by configuration', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
ini_get('y2k_compliance');
ini_get('keep_me');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
ini_get('keep_me');
CODE_SAMPLE
, $configuration)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        foreach ($this->removeFuncCalls as $removeFuncCall) {
            if (!$this->isName($node, $removeFuncCall->getFuncCall())) {
                continue;
            }
            if ($removeFuncCall->getArgumentPositionAndValues() === []) {
                $this->removeNode($node);
                return null;
            }
            $this->refactorFuncCallsWithPositions($node, $removeFuncCall);
        }
        return null;
    }
    /**
     * @param array<string, RemoveFuncCall[]> $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $removeFuncCalls = $configuration[self::REMOVE_FUNC_CALLS] ?? [];
        \RectorPrefix20210422\Webmozart\Assert\Assert::allIsInstanceOf($removeFuncCalls, \Rector\Removing\ValueObject\RemoveFuncCall::class);
        $this->removeFuncCalls = $removeFuncCalls;
    }
    /**
     * @return void
     */
    private function refactorFuncCallsWithPositions(\PhpParser\Node\Expr\FuncCall $funcCall, \Rector\Removing\ValueObject\RemoveFuncCall $removeFuncCall)
    {
        foreach ($removeFuncCall->getArgumentPositionAndValues() as $argumentPosition => $values) {
            if (!$this->isArgumentPositionValueMatch($funcCall, $argumentPosition, $values)) {
                continue;
            }
            if ($this->breakingRemovalGuard->isLegalNodeRemoval($funcCall)) {
                $this->removeNode($funcCall);
            }
        }
    }
    /**
     * @param mixed[] $values
     */
    private function isArgumentPositionValueMatch(\PhpParser\Node\Expr\FuncCall $funcCall, int $argumentPosition, array $values) : bool
    {
        if (!isset($funcCall->args[$argumentPosition])) {
            return \false;
        }
        return $this->valueResolver->isValues($funcCall->args[$argumentPosition]->value, $values);
    }
}
