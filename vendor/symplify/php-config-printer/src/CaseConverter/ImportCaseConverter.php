<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\BuilderHelpers;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * imports: <---
 */
final class ImportCaseConverter implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
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
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter $yamlArgumentSorter, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function getKey() : string
    {
        return \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IMPORTS;
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        return $rootKey === \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IMPORTS;
    }
    public function convertToMethodCall($key, $values) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        if (\is_array($values)) {
            $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE => '', 'type' => null, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS => \false]);
            return $this->createImportMethodCall($arguments);
        }
        throw new \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    /**
     * @param mixed[] $arguments
     */
    private function createImportMethodCall(array $arguments) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $containerConfiguratorVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $args = $this->createArgs($arguments);
        $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, 'import', $args);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
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
            $args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr);
        }
        return $args;
    }
    private function shouldSkipDefaultValue(string $name, $value, array $arguments) : bool
    {
        // skip default value for "ignore_errors"
        if ($name === \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS && $value === \false) {
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
        return isset($arguments[\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS]) && $arguments[\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS] === \false;
    }
    private function replaceImportedFileSuffix($value)
    {
        if (!\is_string($value)) {
            return $value;
        }
        return \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($value, self::INPUT_SUFFIX_REGEX, '.php');
    }
    private function resolveExpr($value) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if (\is_bool($value) || \in_array($value, ['annotations', 'directory', 'glob'], \true)) {
            return \_PhpScopere8e811afab72\PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if ($value === 'not_found') {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('not_found');
        }
        $value = $this->replaceImportedFileSuffix($value);
        return $this->commonNodeFactory->createAbsoluteDirExpr($value);
    }
}
