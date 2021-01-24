<?php

declare (strict_types=1);
namespace RectorPrefix20210124\Symplify\PhpConfigPrinter\CaseConverter;

use RectorPrefix20210124\Nette\Utils\Strings;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use RectorPrefix20210124\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use RectorPrefix20210124\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * Handles this part:
 *
 * services:
 *     Some: Other <---
 */
final class AliasCaseConverter implements \RectorPrefix20210124\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @see https://regex101.com/r/BwXkfO/2/
     * @var string
     */
    private const ARGUMENT_NAME_REGEX = '#\\$(?<argument_name>\\w+)#';
    /**
     * @see https://regex101.com/r/DDuuVM/1
     * @var string
     */
    private const NAMED_ALIAS_REGEX = '#\\w+\\s+\\$\\w+#';
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    /**
     * @var ClassLikeExistenceChecker
     */
    private $classLikeExistenceChecker;
    public function __construct(\RectorPrefix20210124\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \RectorPrefix20210124\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \RectorPrefix20210124\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory, \RectorPrefix20210124\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
        $this->classLikeExistenceChecker = $classLikeExistenceChecker;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        if (!\is_string($key)) {
            throw new \RectorPrefix20210124\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $servicesVariable = new \PhpParser\Node\Expr\Variable(\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        if ($this->classLikeExistenceChecker->doesClassLikeExist($key)) {
            return $this->createFromClassLike($key, $values, $servicesVariable);
        }
        // handles: "SomeClass $someVariable: ..."
        $fullClassName = \RectorPrefix20210124\Nette\Utils\Strings::before($key, ' $');
        if ($fullClassName !== null) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $values);
            return new \PhpParser\Node\Stmt\Expression($methodCall);
        }
        if (\is_string($values) && $values[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$values], \true);
            $methodCall = new \PhpParser\Node\Expr\MethodCall($servicesVariable, \RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
            return new \PhpParser\Node\Stmt\Expression($methodCall);
        }
        if (\is_array($values)) {
            return $this->createFromArrayValues($values, $key, $servicesVariable);
        }
        throw new \RectorPrefix20210124\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (isset($values[\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS])) {
            return \true;
        }
        if (\RectorPrefix20210124\Nette\Utils\Strings::match($key, self::NAMED_ALIAS_REGEX)) {
            return \true;
        }
        if (!\is_string($values)) {
            return \false;
        }
        return $values[0] === '@';
    }
    private function createAliasNode(string $key, string $fullClassName, $serviceValues) : \PhpParser\Node\Expr\MethodCall
    {
        $args = [];
        $classConstFetch = $this->commonNodeFactory->createClassReference($fullClassName);
        \RectorPrefix20210124\Nette\Utils\Strings::match($key, self::ARGUMENT_NAME_REGEX);
        $argumentName = '$' . \RectorPrefix20210124\Nette\Utils\Strings::after($key, '$');
        $concat = new \PhpParser\Node\Expr\BinaryOp\Concat($classConstFetch, new \PhpParser\Node\Scalar\String_(' ' . $argumentName));
        $args[] = new \PhpParser\Node\Arg($concat);
        $serviceName = \ltrim($serviceValues, '@');
        $args[] = new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\String_($serviceName));
        return new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable(\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
    }
    /**
     * @param mixed $values
     */
    private function createFromClassLike(string $key, $values, \PhpParser\Node\Expr\Variable $servicesVariable) : \PhpParser\Node\Stmt\Expression
    {
        $classReference = $this->commonNodeFactory->createClassReference($key);
        $argValues = [];
        $argValues[] = $classReference;
        $argValues[] = $values[\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS] ?? $values;
        $args = $this->argsNodeFactory->createFromValues($argValues, \true);
        $methodCall = new \PhpParser\Node\Expr\MethodCall($servicesVariable, \RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
        return new \PhpParser\Node\Stmt\Expression($methodCall);
    }
    private function createFromAlias(string $className, string $key, \PhpParser\Node\Expr\Variable $servicesVariable) : \PhpParser\Node\Expr\MethodCall
    {
        $classReference = $this->commonNodeFactory->createClassReference($className);
        $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
        return new \PhpParser\Node\Expr\MethodCall($servicesVariable, \RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
    }
    /**
     * @param mixed[] $values
     */
    private function createFromArrayValues(array $values, string $key, \PhpParser\Node\Expr\Variable $servicesVariable) : \PhpParser\Node\Stmt\Expression
    {
        if (isset($values[\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS])) {
            $methodCall = $this->createFromAlias($values[\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS], $key, $servicesVariable);
            unset($values[\RectorPrefix20210124\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS]);
        } else {
            throw new \RectorPrefix20210124\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        /** @var MethodCall $methodCall */
        $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        return new \PhpParser\Node\Stmt\Expression($methodCall);
    }
}
