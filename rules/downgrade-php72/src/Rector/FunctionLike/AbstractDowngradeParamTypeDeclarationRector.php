<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface;
abstract class AbstractDowngradeParamTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector implements \_PhpScopere8e811afab72\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface
{
    public function shouldRemoveParamDeclaration(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($param->variadic) {
            return \false;
        }
        if ($param->type === null) {
            return \false;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        $type = $this->typeUnwrapper->unwrapNullableType($type);
        return \is_a($type, $this->getTypeToRemove(), \true);
    }
    protected function getRectorDefinitionDescription() : string
    {
        return \sprintf("Remove the '%s' param type, add a @param tag instead", $this->getTypeToRemove());
    }
}
