<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\ContextGetByTypeToConstructorInjectionRectorTest
 */
final class ContextGetByTypeToConstructorInjectionRector extends \_PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall\AbstractToConstructorInjectionRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move dependency get via $context->getByType() to constructor injection', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->isInTestClass($node)) {
            return null;
        }
        if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        if (!$this->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Nette\\DI\\Container')) {
            return null;
        }
        if (!$this->isName($node->name, 'getByType')) {
            return null;
        }
        return $this->processMethodCallNode($node);
    }
    private function isInTestClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $classLike = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectTypes($classLike, ['_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase']);
    }
}
