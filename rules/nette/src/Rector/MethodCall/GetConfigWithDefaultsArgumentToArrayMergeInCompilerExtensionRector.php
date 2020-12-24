<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Nette\Tests\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRectorTest
 */
final class GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $this->getConfig($defaults) to array_merge', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\DI\CompilerExtension;

final class SomeExtension extends CompilerExtension
{
    private $defaults = [
        'key' => 'value'
    ];

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\DI\CompilerExtension;

final class SomeExtension extends CompilerExtension
{
    private $defaults = [
        'key' => 'value'
    ];

    public function loadConfiguration()
    {
        $config = array_merge($this->defaults, $this->getConfig());
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
        if (!$this->isOnClassMethodCall($node, '_PhpScoperb75b35f52b74\\Nette\\DI\\CompilerExtension', 'getConfig')) {
            return null;
        }
        if (\count((array) $node->args) !== 1) {
            return null;
        }
        $getConfigMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), 'getConfig');
        $firstArgValue = $node->args[0]->value;
        return $this->createFuncCall('array_merge', [$firstArgValue, $getConfigMethodCall]);
    }
}
