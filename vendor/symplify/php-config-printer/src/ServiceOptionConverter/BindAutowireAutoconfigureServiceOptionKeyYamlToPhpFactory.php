<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class BindAutowireAutoconfigureServiceOptionKeyYamlToPhpFactory implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        if ($key === 'shared') {
            $method = 'share';
        }
        $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        if ($yaml === \false) {
            $methodCall->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($this->commonNodeFactory->createFalse());
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::BIND, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE], \true);
    }
}
