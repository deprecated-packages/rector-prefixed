<?php

declare (strict_types=1);
namespace RectorPrefix20210226\Symplify\PhpConfigPrinter\CaseConverter;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use RectorPrefix20210226\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use RectorPrefix20210226\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _defaults: <---
 */
final class ServicesDefaultsCaseConverter implements \RectorPrefix20210226\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\RectorPrefix20210226\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \RectorPrefix20210226\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \PhpParser\Node\Expr\Variable
    {
        return new \PhpParser\Node\Expr\Variable(\RectorPrefix20210226\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
