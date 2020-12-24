<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ContainerConfiguratorReturnClosureFactory
{
    /**
     * @var ConfiguratorClosureNodeFactory
     */
    private $configuratorClosureNodeFactory;
    /**
     * @var CaseConverterInterface[]
     */
    private $caseConverters = [];
    /**
     * @var NestedCaseConverterInterface[]
     */
    private $nestedCaseConverters = [];
    /**
     * @param CaseConverterInterface[] $caseConverters
     * @param NestedCaseConverterInterface[] $nestedCaseConverters
     */
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory $configuratorClosureNodeFactory, array $caseConverters, array $nestedCaseConverters)
    {
        $this->configuratorClosureNodeFactory = $configuratorClosureNodeFactory;
        $this->caseConverters = $caseConverters;
        $this->nestedCaseConverters = $nestedCaseConverters;
    }
    public function createFromYamlArray(array $arrayData) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->configuratorClosureNodeFactory->createContainerClosureFromStmts($stmts);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($closure);
    }
    /**
     * @return Node[]
     */
    private function createClosureStmts(array $yamlData) : array
    {
        $yamlData = \array_filter($yamlData);
        return $this->createNodesFromCaseConverters($yamlData);
    }
    /**
     * @param mixed[] $yamlData
     * @return Node[]
     */
    private function createNodesFromCaseConverters(array $yamlData) : array
    {
        $nodes = [];
        foreach ($yamlData as $key => $values) {
            $nodes = $this->createInitializeNode($key, $nodes);
            foreach ($values as $nestedKey => $nestedValues) {
                $expression = null;
                $nestedNodes = [];
                if (\is_array($nestedValues)) {
                    foreach ($nestedValues as $subNestedKey => $subNestedValue) {
                        foreach ($this->nestedCaseConverters as $nestedCaseConverter) {
                            if (!$nestedCaseConverter->match($key, $nestedKey)) {
                                continue;
                            }
                            $expression = $nestedCaseConverter->convertToMethodCall($subNestedKey, $subNestedValue);
                            $nestedNodes[] = $expression;
                        }
                    }
                }
                if ($nestedNodes !== []) {
                    $nodes = \array_merge($nodes, $nestedNodes);
                    continue;
                }
                foreach ($this->caseConverters as $caseConverter) {
                    if (!$caseConverter->match($key, $nestedKey, $nestedValues)) {
                        continue;
                    }
                    /** @var string $nestedKey */
                    $expression = $caseConverter->convertToMethodCall($nestedKey, $nestedValues);
                    break;
                }
                if ($expression === null) {
                    continue;
                }
                $nodes[] = $expression;
            }
        }
        return $nodes;
    }
    private function createInitializeAssign(string $variableName, string $methodName) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $servicesVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
        $containerConfiguratorVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($servicesVariable, new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, $methodName));
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createInitializeNode(string $key, array $nodes) : array
    {
        if ($key === \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            $nodes[] = $this->createInitializeAssign(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\MethodName::SERVICES);
        }
        if ($key === \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS) {
            $nodes[] = $this->createInitializeAssign(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::PARAMETERS, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\MethodName::PARAMETERS);
        }
        return $nodes;
    }
}
