<?php

declare (strict_types=1);
namespace RectorPrefix20210205\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20210205\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use RectorPrefix20210205\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use RectorPrefix20210205\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class CallsServiceOptionKeyYamlToPhpFactory implements \RectorPrefix20210205\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\RectorPrefix20210205\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \PhpParser\Node\Expr\MethodCall $methodCall) : \PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createCalls($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \RectorPrefix20210205\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::CALLS;
    }
}
