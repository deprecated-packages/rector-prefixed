<?php

declare (strict_types=1);
namespace RectorPrefix20210219\Symplify\PhpConfigPrinter\CaseConverter;

use RectorPrefix20210219\Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use RectorPrefix20210219\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use RectorPrefix20210219\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use RectorPrefix20210219\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use RectorPrefix20210219\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter;
use RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * imports: <---
 */
final class ImportCaseConverter implements \RectorPrefix20210219\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @see https://regex101.com/r/hOTdIE/1
     * @var string
     */
    private const INPUT_SUFFIX_REGEX = '#\\.(yml|yaml|xml)$#';
    /**
     * @var YamlArgumentSorter
     */
    private $yamlArgumentSorter;
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\RectorPrefix20210219\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter $yamlArgumentSorter, \RectorPrefix20210219\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        return $rootKey === \RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IMPORTS;
    }
    public function convertToMethodCall($key, $values) : \PhpParser\Node\Stmt\Expression
    {
        if (\is_array($values)) {
            $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [\RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE => '', 'type' => null, \RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS => \false]);
            return $this->createImportMethodCall($arguments);
        }
        throw new \RectorPrefix20210219\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    /**
     * @param mixed[] $arguments
     */
    private function createImportMethodCall(array $arguments) : \PhpParser\Node\Stmt\Expression
    {
        $containerConfiguratorVariable = new \PhpParser\Node\Expr\Variable(\RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $args = $this->createArgs($arguments);
        $methodCall = new \PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, 'import', $args);
        return new \PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param mixed[] $arguments
     * @return Arg[]
     */
    private function createArgs(array $arguments) : array
    {
        $args = [];
        foreach ($arguments as $name => $value) {
            if ($this->shouldSkipDefaultValue($name, $value, $arguments)) {
                continue;
            }
            $expr = $this->resolveExpr($value);
            $args[] = new \PhpParser\Node\Arg($expr);
        }
        return $args;
    }
    private function shouldSkipDefaultValue(string $name, $value, array $arguments) : bool
    {
        // skip default value for "ignore_errors"
        if ($name === \RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS && $value === \false) {
            return \true;
        }
        // check if default value for "type"
        if ($name !== 'type') {
            return \false;
        }
        if ($value !== null) {
            return \false;
        }
        // follow by default value for "ignore_errors"
        if (!isset($arguments[\RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS])) {
            return \false;
        }
        return $arguments[\RectorPrefix20210219\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS] === \false;
    }
    /**
     * @return mixed|string
     */
    private function replaceImportedFileSuffix($value)
    {
        if (!\is_string($value)) {
            return $value;
        }
        return \RectorPrefix20210219\Nette\Utils\Strings::replace($value, self::INPUT_SUFFIX_REGEX, '.php');
    }
    private function resolveExpr($value) : \PhpParser\Node\Expr
    {
        if (\is_bool($value)) {
            return \PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if (\in_array($value, ['annotations', 'directory', 'glob'], \true)) {
            return \PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if ($value === 'not_found') {
            return new \PhpParser\Node\Scalar\String_('not_found');
        }
        $value = $this->replaceImportedFileSuffix($value);
        return $this->commonNodeFactory->createAbsoluteDirExpr($value);
    }
}
