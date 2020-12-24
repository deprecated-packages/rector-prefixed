<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Rector\Function_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/php/php-src/pull/3941/files#diff-7e3a1a5df28a1cbd8c0fb6db68f243da
 * @see \Rector\Php74\Tests\Rector\Function_\ReservedFnFunctionRector\ReservedFnFunctionRectorTest
 */
final class ReservedFnFunctionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const RESERVED_NAMES_TO_NEW_ONES = '$reservedNamesToNewOnes';
    /**
     * @var string[]
     */
    private $reservedNamesToNewOnes = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change fn() function name, since it will be reserved keyword', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        function fn($value)
        {
            return $value;
        }

        fn(5);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        function f($value)
        {
            return $value;
        }

        f(5);
    }
}
CODE_SAMPLE
, [self::RESERVED_NAMES_TO_NEW_ONES => ['fn' => 'someFunctionName']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param Function_|FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->reservedNamesToNewOnes as $reservedName => $newName) {
            if (!$this->isName($node->name, $reservedName)) {
                continue;
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
                $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newName);
            } else {
                $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newName);
            }
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->reservedNamesToNewOnes = $configuration[self::RESERVED_NAMES_TO_NEW_ONES] ?? [];
    }
}
