<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\Rector\FunctionLike;

use PhpParser\Node\Identifier;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use Rector\DowngradePhp71\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector;
use Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface;
abstract class AbstractDowngradeParamTypeDeclarationRector extends \Rector\DowngradePhp71\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector implements \Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface
{
    public function shouldRemoveParamDeclaration(\PhpParser\Node\Param $param) : bool
    {
        if ($param->variadic) {
            return \false;
        }
        if ($param->type === null) {
            return \false;
        }
        // It can either be the type, or the nullable type (eg: ?object)
        $isNullableType = $param->type instanceof \PhpParser\Node\NullableType;
        if (!$param->type instanceof \PhpParser\Node\Identifier && !$isNullableType) {
            return \false;
        }
        // If it is the NullableType, extract the name from its inner type
        if ($isNullableType) {
            /** @var NullableType */
            $nullableType = $param->type;
            $typeName = $this->getName($nullableType->type);
        } else {
            $typeName = $this->getName($param->type);
        }
        // Check it is the type to be removed
        return $typeName === $this->getTypeNameToRemove();
    }
    protected function getRectorDefinitionDescription() : string
    {
        return \sprintf("Remove the '%s' param type, add a @param tag instead", $this->getTypeNameToRemove());
    }
}
