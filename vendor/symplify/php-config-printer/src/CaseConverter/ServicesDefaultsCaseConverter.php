<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _defaults: <---
 */
final class ServicesDefaultsCaseConverter implements \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
