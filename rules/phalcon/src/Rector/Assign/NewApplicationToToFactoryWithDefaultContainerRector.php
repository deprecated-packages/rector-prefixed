<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Phalcon\Rector\Assign;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408
 *
 * @see \Rector\Phalcon\Tests\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector\NewApplicationToToFactoryWithDefaultContainerRectorTest
 */
final class NewApplicationToToFactoryWithDefaultContainerRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change new application to default factory with application', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($di)
    {
        $application = new \Phalcon\Mvc\Application($di);

        $response = $application->handle();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($di)
    {
        $container = new \Phalcon\Di\FactoryDefault();
        $application = new \Phalcon\Mvc\Application($container);

        $response = $application->handle($_SERVER["REQUEST_URI"]);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isNewApplication($node->expr)) {
            return null;
        }
        if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return null;
        }
        $containerVariable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('container');
        $factoryAssign = $this->createNewContainerToFactoryDefaultAssign($containerVariable);
        $node->expr->args = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($containerVariable)];
        $this->addNodeBeforeNode($factoryAssign, $node);
        return $node;
    }
    private function isNewApplication(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return \false;
        }
        return $this->isName($expr->class, '_PhpScoper0a6b37af0871\\Phalcon\\Mvc\\Application');
    }
    private function createNewContainerToFactoryDefaultAssign(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($variable, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Phalcon\\Di\\FactoryDefault')));
    }
}
