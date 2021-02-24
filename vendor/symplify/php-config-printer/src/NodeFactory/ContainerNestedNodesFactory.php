<?php

declare (strict_types=1);
namespace RectorPrefix20210224\Symplify\PhpConfigPrinter\NodeFactory;

use PhpParser\Node\Stmt\Expression;
use RectorPrefix20210224\Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter;
final class ContainerNestedNodesFactory
{
    /**
     * @var InstanceOfNestedCaseConverter
     */
    private $instanceOfNestedCaseConverter;
    public function __construct(\RectorPrefix20210224\Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter $instanceOfNestedCaseConverter)
    {
        $this->instanceOfNestedCaseConverter = $instanceOfNestedCaseConverter;
    }
    /**
     * @return Expression[]
     */
    public function createFromValues(array $nestedValues, string $key, $nestedKey) : array
    {
        $nestedNodes = [];
        foreach ($nestedValues as $subNestedKey => $subNestedValue) {
            if (!$this->instanceOfNestedCaseConverter->isMatch($key, $nestedKey)) {
                continue;
            }
            $nestedNodes[] = $this->instanceOfNestedCaseConverter->convertToMethodCall($subNestedKey, $subNestedValue);
        }
        return $nestedNodes;
    }
}
