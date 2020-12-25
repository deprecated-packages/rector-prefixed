<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * parameters: <---
 */
final class ParameterCaseConverter implements \Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var CurrentFilePathProvider
     */
    private $currentFilePathProvider;
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider $currentFilePathProvider, \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function getKey() : string
    {
        return \Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS;
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        return $rootKey === \Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        if (\is_string($values)) {
            $values = $this->prefixWithDirConstantIfExistingPath($values);
        }
        if (\is_array($values)) {
            foreach ($values as $subKey => $subValue) {
                if (!\is_string($subValue)) {
                    continue;
                }
                $values[$subKey] = $this->prefixWithDirConstantIfExistingPath($subValue);
            }
        }
        $args = $this->argsNodeFactory->createFromValues([$key, $values]);
        $parametersVariable = new \PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::PARAMETERS);
        $methodCall = new \PhpParser\Node\Expr\MethodCall($parametersVariable, \Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        return new \PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @return Expr|string
     */
    private function prefixWithDirConstantIfExistingPath(string $value)
    {
        $filePath = $this->currentFilePathProvider->getFilePath();
        if ($filePath === null) {
            return $value;
        }
        $configDirectory = \dirname($filePath);
        $possibleConfigPath = $configDirectory . '/' . $value;
        if (\is_file($possibleConfigPath) || \is_dir($possibleConfigPath)) {
            return $this->commonNodeFactory->createAbsoluteDirExpr($value);
        }
        return $value;
    }
}
