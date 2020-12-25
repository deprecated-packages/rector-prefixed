<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Rector\Closure;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\RectorGenerator\Contract\InternalRectorInterface;
use Rector\SymfonyPhpConfig\NodeAnalyzer\SymfonyPhpConfigClosureAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class AddNewServiceToSymfonyPhpConfigRector extends \Rector\Core\Rector\AbstractRector implements \Rector\RectorGenerator\Contract\InternalRectorInterface
{
    /**
     * @var SymfonyPhpConfigClosureAnalyzer
     */
    private $symfonyPhpConfigClosureAnalyzer;
    /**
     * @var string|null
     */
    private $rectorClass;
    public function __construct(\Rector\SymfonyPhpConfig\NodeAnalyzer\SymfonyPhpConfigClosureAnalyzer $symfonyPhpConfigClosureAnalyzer)
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
        return [\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param Closure $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->rectorClass === null) {
            return null;
        }
        if (!$this->symfonyPhpConfigClosureAnalyzer->isPhpConfigClosure($node)) {
            return null;
        }
        $methodCall = $this->createServicesSetMethodCall($this->rectorClass);
        $node->stmts[] = new \PhpParser\Node\Stmt\Expression($methodCall);
        return $node;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds a new $services->set(...) call to PHP Config', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    private function createServicesSetMethodCall(string $className) : \PhpParser\Node\Expr\MethodCall
    {
        $servicesVariable = new \PhpParser\Node\Expr\Variable('services');
        $referenceClassConstFetch = new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name\FullyQualified($className), new \PhpParser\Node\Identifier('class'));
        $args = [new \PhpParser\Node\Arg($referenceClassConstFetch)];
        return new \PhpParser\Node\Expr\MethodCall($servicesVariable, 'set', $args);
    }
}
