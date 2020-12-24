<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _instanceof: <---
 */
final class InstanceOfNestedCaseConverter implements \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\NestedCaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $instanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($instanceofMethodCall);
    }
    public function match(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
