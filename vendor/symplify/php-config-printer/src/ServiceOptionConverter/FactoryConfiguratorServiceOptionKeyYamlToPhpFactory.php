<?php

declare (strict_types=1);
namespace RectorPrefix20210205\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20210205\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use RectorPrefix20210205\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use RectorPrefix20210205\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class FactoryConfiguratorServiceOptionKeyYamlToPhpFactory implements \RectorPrefix20210205\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\RectorPrefix20210205\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \PhpParser\Node\Expr\MethodCall $methodCall) : \PhpParser\Node\Expr\MethodCall
    {
        $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
        return new \PhpParser\Node\Expr\MethodCall($methodCall, 'factory', $args);
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\RectorPrefix20210205\Symplify\PhpConfigPrinter\ValueObject\YamlKey::FACTORY, \RectorPrefix20210205\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CONFIGURATOR], \true);
    }
}
