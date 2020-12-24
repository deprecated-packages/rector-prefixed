<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\RoutingCaseConverter;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class PathRoutingCaseConverter implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface
{
    /**
     * @var string[]
     */
    private const NESTED_KEYS = ['controller', 'defaults', self::METHODS, 'requirements'];
    /**
     * @var string
     */
    private const PATH = 'path';
    /**
     * @var string
     */
    private const METHODS = 'methods';
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function match(string $key, $values) : bool
    {
        return isset($values[self::PATH]);
    }
    public function convertToMethodCall(string $key, $values) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @todo args
        $args = $this->createAddArgs($key, $values);
        $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($variable, 'add', $args);
        foreach (self::NESTED_KEYS as $nestedKey) {
            if (!isset($values[$nestedKey])) {
                continue;
            }
            $nestedValues = $values[$nestedKey];
            // Transform methods as string GET|HEAD to array
            if ($nestedKey === self::METHODS && \is_string($nestedValues)) {
                $nestedValues = \explode('|', $nestedValues);
            }
            $args = $this->argsNodeFactory->createFromValues([$nestedValues]);
            $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($methodCall, $nestedKey, $args);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param mixed $values
     * @return Arg[]
     */
    private function createAddArgs(string $key, $values) : array
    {
        $argumentValues = [];
        $argumentValues[] = $key;
        if (isset($values[self::PATH])) {
            $argumentValues[] = $values[self::PATH];
        }
        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
