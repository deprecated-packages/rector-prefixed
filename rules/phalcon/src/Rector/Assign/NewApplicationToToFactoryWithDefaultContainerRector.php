<?php

declare (strict_types=1);
namespace Rector\Phalcon\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408
 *
 * @see \Rector\Phalcon\Tests\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector\NewApplicationToToFactoryWithDefaultContainerRectorTest
 */
final class NewApplicationToToFactoryWithDefaultContainerRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change new application to default factory with application', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isNewApplication($node->expr)) {
            return null;
        }
        if (!$node->expr instanceof \PhpParser\Node\Expr\New_) {
            return null;
        }
        $containerVariable = new \PhpParser\Node\Expr\Variable('container');
        $factoryAssign = $this->createNewContainerToFactoryDefaultAssign($containerVariable);
        $node->expr->args = [new \PhpParser\Node\Arg($containerVariable)];
        $this->addNodeBeforeNode($factoryAssign, $node);
        return $node;
    }
    private function isNewApplication(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\New_) {
            return \false;
        }
        return $this->isName($expr->class, 'RectorPrefix20201228\\Phalcon\\Mvc\\Application');
    }
    private function createNewContainerToFactoryDefaultAssign(\PhpParser\Node\Expr\Variable $variable) : \PhpParser\Node\Expr\Assign
    {
        return new \PhpParser\Node\Expr\Assign($variable, new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified('RectorPrefix20201228\\Phalcon\\Di\\FactoryDefault')));
    }
}
