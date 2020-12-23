<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * Handles this part:
 *
 * services:
 *     Some: Other <---
 */
final class AliasCaseConverter implements \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
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
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression
    {
        if (!\is_string($key)) {
            throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $servicesVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        if (\class_exists($key) || \interface_exists($key)) {
            $classReference = $this->commonNodeFactory->createClassReference($key);
            $argValues = [];
            $argValues[] = $classReference;
            $argValues[] = $values[\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS] ?? $values;
            $args = $this->argsNodeFactory->createFromValues($argValues, \true);
            $methodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($methodCall);
        }
        // handles: "SomeClass $someVariable: ..."
        $fullClassName = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::before($key, ' $');
        if ($fullClassName !== null) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $values);
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($methodCall);
        }
        $methodCall = null;
        if (isset($values[\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS])) {
            $className = $values[\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS];
            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
            $methodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
            unset($values[\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS]);
        }
        /** @var string|mixed[] $values */
        if (\is_string($values) && $values[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$values], \true);
            $methodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
        } elseif (\is_array($values)) {
            if ($methodCall === null) {
                throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
            }
            /** @var MethodCall $methodCall */
            $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        }
        if ($methodCall === null) {
            throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (isset($values[\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS])) {
            return \true;
        }
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($key, self::NAMED_ALIAS_REGEX)) {
            return \true;
        }
        return \is_string($values) && $values[0] === '@';
    }
    private function createAliasNode(string $key, string $fullClassName, $serviceValues) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        $args = [];
        $classConstFetch = $this->commonNodeFactory->createClassReference($fullClassName);
        \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($key, self::ARGUMENT_NAME_REGEX);
        $argumentName = '$' . \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::after($key, '$');
        $concat = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat($classConstFetch, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_(' ' . $argumentName));
        $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($concat);
        $serviceName = \ltrim($serviceValues, '@');
        $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($serviceName));
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
    }
}
