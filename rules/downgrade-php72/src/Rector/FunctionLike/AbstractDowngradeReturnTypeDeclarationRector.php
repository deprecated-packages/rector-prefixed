<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface;
abstract class AbstractDowngradeReturnTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector implements \_PhpScopere8e811afab72\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface
{
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function shouldRemoveReturnDeclaration(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($functionLike->returnType === null) {
            return \false;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        $type = $this->typeUnwrapper->unwrapNullableType($type);
        return \is_a($type, $this->getTypeToRemove(), \true);
    }
}
