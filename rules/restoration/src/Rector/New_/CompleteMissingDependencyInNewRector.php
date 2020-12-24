<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Rector\New_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\CompleteMissingDependencyInNewRectorTest
 */
final class CompleteMissingDependencyInNewRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Complete missing constructor dependency instance by type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
            $new = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($classToInstantiate));
            $node->args[$position] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($new);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->classToInstantiateByType = $configuration[self::CLASS_TO_INSTANTIATE_BY_TYPE] ?? [];
    }
    private function shouldSkipNew(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : bool
    {
        $constructorMethodReflection = $this->getNewNodeClassConstructorMethodReflection($new);
        if ($constructorMethodReflection === null) {
            return \true;
        }
        return $constructorMethodReflection->getNumberOfRequiredParameters() <= \count((array) $new->args);
    }
    private function getNewNodeClassConstructorMethodReflection(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : ?\ReflectionMethod
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
