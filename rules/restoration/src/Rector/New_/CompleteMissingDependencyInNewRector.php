<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\Rector\New_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\CompleteMissingDependencyInNewRectorTest
 */
final class CompleteMissingDependencyInNewRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const CLASS_TO_INSTANTIATE_BY_TYPE = '$classToInstantiateByType';
    /**
     * @var string[]
     */
    private $classToInstantiateByType = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Complete missing constructor dependency instance by type', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $valueObject = new RandomValueObject();
    }
}

class RandomValueObject
{
    public function __construct(RandomDependency $randomDependency)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $valueObject = new RandomValueObject(new RandomDependency());
    }
}

class RandomValueObject
{
    public function __construct(RandomDependency $randomDependency)
    {
    }
}
CODE_SAMPLE
, [self::CLASS_TO_INSTANTIATE_BY_TYPE => ['RandomDependency' => 'RandomDependency']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkipNew($node)) {
            return null;
        }
        /** @var ReflectionMethod $constructorMethodReflection */
        $constructorMethodReflection = $this->getNewNodeClassConstructorMethodReflection($node);
        foreach ($constructorMethodReflection->getParameters() as $position => $reflectionParameter) {
            // argument is already set
            if (isset($node->args[$position])) {
                continue;
            }
            $classToInstantiate = $this->resolveClassToInstantiateByParameterReflection($reflectionParameter);
            if ($classToInstantiate === null) {
                continue;
            }
            $new = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($classToInstantiate));
            $node->args[$position] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($new);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->classToInstantiateByType = $configuration[self::CLASS_TO_INSTANTIATE_BY_TYPE] ?? [];
    }
    private function shouldSkipNew(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : bool
    {
        $constructorMethodReflection = $this->getNewNodeClassConstructorMethodReflection($new);
        if ($constructorMethodReflection === null) {
            return \true;
        }
        return $constructorMethodReflection->getNumberOfRequiredParameters() <= \count((array) $new->args);
    }
    private function getNewNodeClassConstructorMethodReflection(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : ?\ReflectionMethod
    {
        $className = $this->getName($new->class);
        if ($className === null) {
            return null;
        }
        if (!\class_exists($className)) {
            return null;
        }
        $reflectionClass = new \ReflectionClass($className);
        return $reflectionClass->getConstructor();
    }
    private function resolveClassToInstantiateByParameterReflection(\ReflectionParameter $reflectionParameter) : ?string
    {
        $parameterType = $reflectionParameter->getType();
        if ($parameterType === null) {
            return null;
        }
        $requiredType = (string) $parameterType;
        return $this->classToInstantiateByType[$requiredType] ?? null;
    }
}
