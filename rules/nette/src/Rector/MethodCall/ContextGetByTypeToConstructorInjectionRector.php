<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\ContextGetByTypeToConstructorInjectionRectorTest
 */
final class ContextGetByTypeToConstructorInjectionRector extends \_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move dependency get via $context->getByType() to constructor injection', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Nette\DI\Container
     */
    private $context;

    public function run()
    {
        $someTypeToInject = $this->context->getByType(SomeTypeToInject::class);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Nette\DI\Container
     */
    private $context;

    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;

    public function __construct(SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }

    public function run()
    {
        $someTypeToInject = $this->someTypeToInject;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->isInTestClass($node)) {
            return null;
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Nette\\DI\\Container')) {
            return null;
        }
        if (!$this->isName($node->name, 'getByType')) {
            return null;
        }
        return $this->processMethodCallNode($node);
    }
    private function isInTestClass(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $classLike = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectTypes($classLike, ['_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase']);
    }
}
