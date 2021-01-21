<?php

declare (strict_types=1);
namespace RectorPrefix20210121\Symplify\PhpConfigPrinter\NodeFactory\Service;

use RectorPrefix20210121\Nette\Utils\Strings;
use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class ServiceOptionNodeFactory
{
    /**
     * @var ServiceOptionsKeyYamlToPhpFactoryInterface[]
     */
    private $serviceOptionKeyYamlToPhpFactories = [];
    /**
     * @var ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    /**
     * @param ServiceOptionsKeyYamlToPhpFactoryInterface[] $serviceOptionKeyYamlToPhpFactories
     */
    public function __construct(\RectorPrefix20210121\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer $serviceOptionAnalyzer, array $serviceOptionKeyYamlToPhpFactories)
    {
        $this->serviceOptionKeyYamlToPhpFactories = $serviceOptionKeyYamlToPhpFactories;
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
    }
    public function convertServiceOptionsToNodes(array $servicesValues, \PhpParser\Node\Expr\MethodCall $methodCall) : \PhpParser\Node\Expr\MethodCall
    {
        $servicesValues = $this->unNestArguments($servicesValues);
        foreach ($servicesValues as $key => $value) {
            // options started by decoration_<option> are used as options of the method decorate().
            if (\RectorPrefix20210121\Nette\Utils\Strings::startsWith($key, 'decoration_') || $key === 'alias') {
                continue;
            }
            foreach ($this->serviceOptionKeyYamlToPhpFactories as $serviceOptionKeyYamlToPhpFactory) {
                if (!$serviceOptionKeyYamlToPhpFactory->isMatch($key, $value)) {
                    continue;
                }
                $methodCall = $serviceOptionKeyYamlToPhpFactory->decorateServiceMethodCall($key, $value, $servicesValues, $methodCall);
                continue 2;
            }
        }
        return $methodCall;
    }
    /**
     * @return array<string, mixed>
     */
    private function unNestArguments(array $servicesValues) : array
    {
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($servicesValues)) {
            return $servicesValues;
        }
        return [\RectorPrefix20210121\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::ARGUMENTS => $servicesValues];
    }
}
