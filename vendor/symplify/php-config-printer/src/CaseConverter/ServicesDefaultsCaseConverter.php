<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     _defaults: <---
 */
final class ServicesDefaultsCaseConverter implements \Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \PhpParser\Node\Expr\Variable
    {
        return new \PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
