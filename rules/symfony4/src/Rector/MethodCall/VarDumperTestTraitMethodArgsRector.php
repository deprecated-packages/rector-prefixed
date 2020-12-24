<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony4\Tests\Rector\MethodCall\VarDumperTestTraitMethodArgsRector\VarDumperTestTraitMethodArgsRectorTest
 */
final class VarDumperTestTraitMethodArgsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds a new `$filter` argument in `VarDumperTestTrait->assertDumpEquals()` and `VarDumperTestTrait->assertDumpMatchesFormat()` in Validator in Symfony.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$varDumperTestTrait->assertDumpEquals($dump, $data, $message = "");', '$varDumperTestTrait->assertDumpEquals($dump, $data, $filter = 0, $message = "");'), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$varDumperTestTrait->assertDumpMatchesFormat($dump, $data, $message = "");', '$varDumperTestTrait->assertDumpMatchesFormat($dump, $data, $filter = 0, $message = "");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Symfony\\Component\\VarDumper\\Test\\VarDumperTestTrait')) {
            return null;
        }
        if (!$this->isNames($node->name, ['assertDumpEquals', 'assertDumpMatchesFormat'])) {
            return null;
        }
        if (\count((array) $node->args) <= 2 || $node->args[2]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return null;
        }
        if ($node->args[2]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            $node->args[3] = $node->args[2];
            $node->args[2] = $this->createArg(0);
            return $node;
        }
        return null;
    }
}
