<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _defaults: <---
 */
final class ServicesDefaultsCaseConverter implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
