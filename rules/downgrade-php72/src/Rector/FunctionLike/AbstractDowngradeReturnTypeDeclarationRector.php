<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp72\Rector\FunctionLike;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector;
use _PhpScoper0a6b37af0871\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface;
abstract class AbstractDowngradeReturnTypeDeclarationRector extends \_PhpScoper0a6b37af0871\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector implements \_PhpScoper0a6b37af0871\Rector\DowngradePhp72\Contract\Rector\DowngradeTypeRectorInterface
{
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function shouldRemoveReturnDeclaration(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($functionLike->returnType === null) {
            return \false;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        $type = $this->typeUnwrapper->unwrapNullableType($type);
        return \is_a($type, $this->getTypeToRemove(), \true);
    }
}
