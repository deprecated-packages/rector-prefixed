<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ServiceOptionConverter;

use PhpParser\Node\Expr\MethodCall;
use Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class PropertiesServiceOptionKeyYamlToPhpFactory implements \Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \PhpParser\Node\Expr\MethodCall $methodCall) : \PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createProperties($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::PROPERTIES;
    }
}
