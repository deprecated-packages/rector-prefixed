<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class CompactConverter
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    public function hasAllArgumentsNamed(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : bool
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
    public function convertToArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_
    {
        $array = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_();
        foreach ($funcCall->args as $arg) {
            /** @var string|null $variableName */
            $variableName = $this->valueResolver->getValue($arg->value);
            if (!\is_string($variableName)) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            $array->items[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName), new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($variableName));
        }
        return $array;
    }
}
