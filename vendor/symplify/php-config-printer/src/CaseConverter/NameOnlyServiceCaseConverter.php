<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class NameOnlyServiceCaseConverter implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($classConstFetch)]);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
