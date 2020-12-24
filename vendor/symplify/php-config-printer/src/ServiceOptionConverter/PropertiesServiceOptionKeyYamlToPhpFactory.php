<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class PropertiesServiceOptionKeyYamlToPhpFactory implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createProperties($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::PROPERTIES;
    }
}
