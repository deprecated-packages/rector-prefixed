<?php

declare (strict_types=1);
namespace Rector\Symfony4\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony4\Tests\Rector\MethodCall\VarDumperTestTraitMethodArgsRector\VarDumperTestTraitMethodArgsRectorTest
 */
final class VarDumperTestTraitMethodArgsRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds a new `$filter` argument in `VarDumperTestTrait->assertDumpEquals()` and `VarDumperTestTrait->assertDumpMatchesFormat()` in Validator in Symfony.', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$varDumperTestTrait->assertDumpEquals($dump, $data, $message = "");', '$varDumperTestTrait->assertDumpEquals($dump, $data, $filter = 0, $message = "");'), new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$varDumperTestTrait->assertDumpMatchesFormat($dump, $data, $message = "");', '$varDumperTestTrait->assertDumpMatchesFormat($dump, $data, $filter = 0, $message = "");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, 'RectorPrefix20201228\\Symfony\\Component\\VarDumper\\Test\\VarDumperTestTrait')) {
            return null;
        }
        if (!$this->isNames($node->name, ['assertDumpEquals', 'assertDumpMatchesFormat'])) {
            return null;
        }
        if (\count($node->args) <= 2) {
            return null;
        }
        if ($node->args[2]->value instanceof \PhpParser\Node\Expr\ConstFetch) {
            return null;
        }
        if ($node->args[2]->value instanceof \PhpParser\Node\Scalar\String_) {
            $node->args[3] = $node->args[2];
            $node->args[2] = $this->createArg(0);
            return $node;
        }
        return null;
    }
}
