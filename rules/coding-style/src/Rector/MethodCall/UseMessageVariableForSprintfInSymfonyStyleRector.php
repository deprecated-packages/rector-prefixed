<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector\UseMessageVariableForSprintfInSymfonyStyleRectorTest
 */
final class UseMessageVariableForSprintfInSymfonyStyleRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Decouple $message property from sprintf() calls in $this->smyfonyStyle->method()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Console\Style\SymfonyStyle;

final class SomeClass
{
    public function run(SymfonyStyle $symfonyStyle)
    {
        $symfonyStyle->info(sprintf('Hi %s', 'Tom'));
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Console\Style\SymfonyStyle;

final class SomeClass
{
    public function run(SymfonyStyle $symfonyStyle)
    {
        $message = sprintf('Hi %s', 'Tom');
        $symfonyStyle->info($message);
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Style\\SymfonyStyle')) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $argValue = $node->args[0]->value;
        if (!$this->isFuncCallName($argValue, 'sprintf')) {
            return null;
        }
        $messageVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('message');
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($messageVariable, $argValue);
        $this->addNodeBeforeNode($assign, $node);
        $node->args[0]->value = $messageVariable;
        return $node;
    }
}
