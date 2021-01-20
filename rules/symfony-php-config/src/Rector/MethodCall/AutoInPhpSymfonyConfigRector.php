<?php

declare (strict_types=1);
namespace Rector\SymfonyPhpConfig\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
use Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\SymfonyPhpConfig\NodeAnalyzer\SymfonyPhpConfigClosureAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see phpstan rule https://github.com/symplify/coding-standard/blob/master/docs/phpstan_rules.md#check-required-autowire-autoconfigure-and-public-are-used-in-config-service-rule
 * @see \Rector\SymfonyPhpConfig\Tests\Rector\MethodCall\AutoInPhpSymfonyConfigRector\AutoInPhpSymfonyConfigRectorTest
 */
final class AutoInPhpSymfonyConfigRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const REQUIRED_METHOD_NAMES = ['public', 'autowire', 'autoconfigure'];
    /**
     * @var SymfonyPhpConfigClosureAnalyzer
     */
    private $symfonyPhpConfigClosureAnalyzer;
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    public function __construct(\Rector\SymfonyPhpConfig\NodeAnalyzer\SymfonyPhpConfigClosureAnalyzer $symfonyPhpConfigClosureAnalyzer, \Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer)
    {
        $this->symfonyPhpConfigClosureAnalyzer = $symfonyPhpConfigClosureAnalyzer;
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make sure there is public(), autowire(), autoconfigure() calls on defaults() in Symfony configs', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire();
};
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->public()
        ->autoconfigure();
};
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
        if ($this->shouldSkipMethodCall($node)) {
            return null;
        }
        $missingMethodNames = $this->resolveMissingMethodNames($node);
        if ($missingMethodNames === []) {
            return null;
        }
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::IS_FRESH_NODE, \true);
        $methodCall = clone $node;
        foreach ($missingMethodNames as $missingMethodName) {
            $methodCall = new \PhpParser\Node\Expr\MethodCall($methodCall, $missingMethodName);
        }
        return $methodCall;
    }
    private function shouldSkipMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $isFreshNode = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::IS_FRESH_NODE);
        if ($isFreshNode) {
            return \true;
        }
        $closure = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE);
        if ($closure === null) {
            return \true;
        }
        if (!$this->symfonyPhpConfigClosureAnalyzer->isPhpConfigClosure($closure)) {
            return \true;
        }
        if (!$this->fluentChainMethodCallNodeAnalyzer->isLastChainMethodCall($methodCall)) {
            return \true;
        }
        $rootMethodCall = $this->fluentChainMethodCallNodeAnalyzer->resolveRootMethodCall($methodCall);
        if (!$rootMethodCall instanceof \PhpParser\Node\Expr\MethodCall) {
            return \true;
        }
        return !$this->isName($rootMethodCall->name, 'defaults');
    }
    /**
     * @return string[]
     */
    private function resolveMissingMethodNames(\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $methodCallNames = $this->fluentChainMethodCallNodeAnalyzer->collectMethodCallNamesInChain($methodCall);
        return \array_diff(self::REQUIRED_METHOD_NAMES, $methodCallNames);
    }
}
