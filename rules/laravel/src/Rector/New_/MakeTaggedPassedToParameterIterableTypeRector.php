<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\New_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/5.8/upgrade#container-generators
 *
 * @see \Rector\Laravel\Tests\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector\MakeTaggedPassedToParameterIterableTypeRectorTest
 */
final class MakeTaggedPassedToParameterIterableTypeRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type to iterable, if passed one', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class AnotherClass
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function create()
    {
        $tagged = $this->app->tagged('some_tagged');
        return new SomeClass($tagged);
    }
}

class SomeClass
{
    public function __construct(array $items)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class AnotherClass
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    private $app;

    public function create()
    {
        $tagged = $this->app->tagged('some_tagged');
        return new SomeClass($tagged);
    }
}

class SomeClass
{
    public function __construct(iterable $items)
    {
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $className = $this->getName($node->class);
        if ($className === null) {
            return null;
        }
        $class = $this->nodeRepository->findClass($className);
        if ($class === null) {
            return null;
        }
        foreach ($node->args as $arg) {
            $this->refactorClassWithArgType($class, $arg);
        }
        return null;
    }
    private function refactorClassWithArgType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg $arg) : void
    {
        $argValueType = $this->getStaticType($arg->value);
        $constructClassMethod = $class->getMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $argumentPosition = (int) $arg->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION);
        if ($constructClassMethod === null) {
            return;
        }
        $param = $constructClassMethod->params[$argumentPosition] ?? null;
        if ($param === null) {
            return;
        }
        $argTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($argValueType);
        $param->type = $argTypeNode;
    }
}
