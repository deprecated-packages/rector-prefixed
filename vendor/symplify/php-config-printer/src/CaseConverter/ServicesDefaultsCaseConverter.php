<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _defaults: <---
 */
final class ServicesDefaultsCaseConverter implements \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
