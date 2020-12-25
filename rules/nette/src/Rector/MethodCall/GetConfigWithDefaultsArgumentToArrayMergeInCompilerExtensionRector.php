<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Nette\Tests\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRectorTest
 */
final class GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $this->getConfig($defaults) to array_merge', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isOnClassMethodCall($node, '_PhpScoper267b3276efc2\\Nette\\DI\\CompilerExtension', 'getConfig')) {
            return null;
        }
        if (\count($node->args) !== 1) {
            return null;
        }
        $getConfigMethodCall = new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable('this'), 'getConfig');
        $firstArgValue = $node->args[0]->value;
        return $this->createFuncCall('array_merge', [$firstArgValue, $getConfigMethodCall]);
    }
}
