<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class CompactConverter
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function hasAllArgumentsNamed(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        foreach ($funcCall->args as $arg) {
            /** @var string|null $variableName */
            $variableName = $this->valueResolver->getValue($arg->value);
            if (!\is_string($variableName)) {
                return \false;
            }
        }
        return \true;
    }
    public function convertToArray(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $array = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_();
        foreach ($funcCall->args as $arg) {
            /** @var string|null $variableName */
            $variableName = $this->valueResolver->getValue($arg->value);
            if (!\is_string($variableName)) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $array->items[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName), new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($variableName));
        }
        return $array;
    }
}
