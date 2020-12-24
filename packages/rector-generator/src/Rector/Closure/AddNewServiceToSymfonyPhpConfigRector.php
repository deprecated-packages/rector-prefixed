<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Contract\InternalRectorInterface;
use _PhpScopere8e811afab72\Rector\SymfonyPhpConfig\NodeAnalyzer\SymfonyPhpConfigClosureAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class AddNewServiceToSymfonyPhpConfigRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\RectorGenerator\Contract\InternalRectorInterface
{
    /**
     * @var SymfonyPhpConfigClosureAnalyzer
     */
    private $symfonyPhpConfigClosureAnalyzer;
    /**
     * @var string|null
     */
    private $rectorClass;
    public function __construct(\_PhpScopere8e811afab72\Rector\SymfonyPhpConfig\NodeAnalyzer\SymfonyPhpConfigClosureAnalyzer $symfonyPhpConfigClosureAnalyzer)
    {
        $this->symfonyPhpConfigClosureAnalyzer = $symfonyPhpConfigClosureAnalyzer;
    }
    public function setRectorClass(string $rectorClass) : void
    {
        $this->rectorClass = $rectorClass;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param Closure $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->rectorClass === null) {
            return null;
        }
        if (!$this->symfonyPhpConfigClosureAnalyzer->isPhpConfigClosure($node)) {
            return null;
        }
        $methodCall = $this->createServicesSetMethodCall($this->rectorClass);
        $node->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
        return $node;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds a new $services->set(...) call to PHP Config', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
};
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(AddNewServiceToSymfonyPhpConfigRector::class);
};
CODE_SAMPLE
)]);
    }
    private function createServicesSetMethodCall(string $className) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $servicesVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('services');
        $referenceClassConstFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($className), new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('class'));
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($referenceClassConstFetch)];
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($servicesVariable, 'set', $args);
    }
}
