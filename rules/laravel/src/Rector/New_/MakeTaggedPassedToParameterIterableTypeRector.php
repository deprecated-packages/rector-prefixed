<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Laravel\Rector\New_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/5.8/upgrade#container-generators
 *
 * @see \Rector\Laravel\Tests\Rector\New_\MakeTaggedPassedToParameterIterableTypeRector\MakeTaggedPassedToParameterIterableTypeRectorTest
 */
final class MakeTaggedPassedToParameterIterableTypeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type to iterable, if passed one', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
    private function refactorClassWithArgType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Arg $arg) : void
    {
        $argValueType = $this->getStaticType($arg->value);
        $constructClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $argumentPosition = (int) $arg->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ARGUMENT_POSITION);
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
