<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _instanceof: <---
 */
final class InstanceOfNestedCaseConverter implements \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $instanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($instanceofMethodCall);
    }
    public function match(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
