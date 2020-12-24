<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class CompactConverter
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function hasAllArgumentsNamed(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : bool
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
    public function convertToArray(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_
    {
        $array = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_();
        foreach ($funcCall->args as $arg) {
            /** @var string|null $variableName */
            $variableName = $this->valueResolver->getValue($arg->value);
            if (!\is_string($variableName)) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            $array->items[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($variableName), new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($variableName));
        }
        return $array;
    }
}
