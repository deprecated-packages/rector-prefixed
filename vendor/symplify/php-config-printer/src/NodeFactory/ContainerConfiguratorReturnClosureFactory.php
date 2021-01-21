<?php

declare (strict_types=1);
namespace RectorPrefix20210121\Symplify\PhpConfigPrinter\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
     * @var InstanceOfNestedCaseConverter
     */
    private $instanceOfNestedCaseConverter;
    /**
     * @param CaseConverterInterface[] $caseConverters
     */
    public function __construct(\RectorPrefix20210121\Symplify\PhpConfigPrinter\PhpParser\NodeFactory\ConfiguratorClosureNodeFactory $configuratorClosureNodeFactory, array $caseConverters, \RectorPrefix20210121\Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter $instanceOfNestedCaseConverter)
    {
        $this->configuratorClosureNodeFactory = $configuratorClosureNodeFactory;
        $this->caseConverters = $caseConverters;
        $this->instanceOfNestedCaseConverter = $instanceOfNestedCaseConverter;
    }
    public function createFromYamlArray(array $arrayData) : \PhpParser\Node\Stmt\Return_
    {
        $stmts = $this->createClosureStmts($arrayData);
        $closure = $this->configuratorClosureNodeFactory->createContainerClosureFromStmts($stmts);
        return new \PhpParser\Node\Stmt\Return_($closure);
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
                        if (!$this->instanceOfNestedCaseConverter->isMatch($key, $nestedKey)) {
                            continue;
                        }
                        $nestedNodes[] = $this->instanceOfNestedCaseConverter->convertToMethodCall($subNestedKey, $subNestedValue);
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
    private function createInitializeAssign(string $variableName, string $methodName) : \PhpParser\Node\Stmt\Expression
    {
        $servicesVariable = new \PhpParser\Node\Expr\Variable($variableName);
        $containerConfiguratorVariable = new \PhpParser\Node\Expr\Variable(\RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $assign = new \PhpParser\Node\Expr\Assign($servicesVariable, new \PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, $methodName));
        return new \PhpParser\Node\Stmt\Expression($assign);
    }
    /**
     * @return mixed[]
     */
    private function createInitializeNode(string $key, array $nodes) : array
    {
        if ($key === \RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            $nodes[] = $this->createInitializeAssign(\RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES, \RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\MethodName::SERVICES);
        }
        if ($key === \RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS) {
            $nodes[] = $this->createInitializeAssign(\RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\VariableName::PARAMETERS, \RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\MethodName::PARAMETERS);
        }
        return $nodes;
    }
}
