<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     Some:
 *         class: Other <---
 */
final class ClassServiceCaseConverter implements \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]]);
        $setMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        unset($values[\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]);
        $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $setMethodCall);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (\is_array($values) && \count($values) !== 1) {
            return \false;
        }
        return isset($values[\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]) && !isset($values[\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS]);
    }
}
