<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp72\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface;
abstract class AbstractDowngradeParamTypeDeclarationRector extends \_PhpScoperb75b35f52b74\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector implements \_PhpScoperb75b35f52b74\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface
{
    public function shouldRemoveParamDeclaration(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : bool
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
