<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * framework: <---
 *     key: value
 */
final class ExtensionConverter implements \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var string
     */
    private $rootKey;
    /**
     * @var YamlKey
     */
    private $yamlKey;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\YamlKey $yamlKey)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlKey = $yamlKey;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, $this->yamlKey->provideRootKeys(), \true);
    }
}
