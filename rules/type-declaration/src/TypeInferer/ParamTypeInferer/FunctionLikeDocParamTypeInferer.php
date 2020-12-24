<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class FunctionLikeDocParamTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function inferParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $functionLike = $this->resolveScopeNode($param);
        if ($functionLike === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $paramTypesByName = $phpDocInfo->getParamTypesByName();
        if ($paramTypesByName === []) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $this->matchParamNodeFromDoc($paramTypesByName, $param);
    }
    private function resolveScopeNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike
    {
        return $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
    /**
     * @param Type[] $paramWithTypes
     */
    private function matchParamNodeFromDoc(array $paramWithTypes, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $paramNodeName = '$' . $this->nodeNameResolver->getName($param->var);
        return $paramWithTypes[$paramNodeName] ?? new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
