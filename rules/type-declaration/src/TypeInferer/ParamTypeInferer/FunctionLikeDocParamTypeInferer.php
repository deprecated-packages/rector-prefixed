<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class FunctionLikeDocParamTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function inferParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $functionLike = $this->resolveScopeNode($param);
        if ($functionLike === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $paramTypesByName = $phpDocInfo->getParamTypesByName();
        if ($paramTypesByName === []) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $this->matchParamNodeFromDoc($paramTypesByName, $param);
    }
    private function resolveScopeNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike
    {
        return $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
    /**
     * @param Type[] $paramWithTypes
     */
    private function matchParamNodeFromDoc(array $paramWithTypes, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $paramNodeName = '$' . $this->nodeNameResolver->getName($param->var);
        return $paramWithTypes[$paramNodeName] ?? new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
}
