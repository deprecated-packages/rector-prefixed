<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Phalcon\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408
 *
 * @see \Rector\Phalcon\Tests\Rector\Assign\NewApplicationToToFactoryWithDefaultContainerRector\NewApplicationToToFactoryWithDefaultContainerRectorTest
 */
final class NewApplicationToToFactoryWithDefaultContainerRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change new application to default factory with application', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isNewApplication($node->expr)) {
            return null;
        }
        if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return null;
        }
        $containerVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('container');
        $factoryAssign = $this->createNewContainerToFactoryDefaultAssign($containerVariable);
        $node->expr->args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($containerVariable)];
        $this->addNodeBeforeNode($factoryAssign, $node);
        return $node;
    }
    private function isNewApplication(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return \false;
        }
        return $this->isName($expr->class, '_PhpScoperb75b35f52b74\\Phalcon\\Mvc\\Application');
    }
    private function createNewContainerToFactoryDefaultAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($variable, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Phalcon\\Di\\FactoryDefault')));
    }
}
