<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class FunctionLikeDocParamTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function inferParam(\PhpParser\Node\Param $param) : \PHPStan\Type\Type
    {
        $functionLike = $this->resolveScopeNode($param);
        if ($functionLike === null) {
            return new \PHPStan\Type\MixedType();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \PHPStan\Type\MixedType();
        }
        $paramTypesByName = $phpDocInfo->getParamTypesByName();
        if ($paramTypesByName === []) {
            return new \PHPStan\Type\MixedType();
        }
        return $this->matchParamNodeFromDoc($paramTypesByName, $param);
    }
    private function resolveScopeNode(\PhpParser\Node\Param $param) : ?\PhpParser\Node\FunctionLike
    {
        return $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
    /**
     * @param Type[] $paramWithTypes
     */
    private function matchParamNodeFromDoc(array $paramWithTypes, \PhpParser\Node\Param $param) : \PHPStan\Type\Type
    {
        $paramNodeName = '$' . $this->nodeNameResolver->getName($param->var);
        return $paramWithTypes[$paramNodeName] ?? new \PHPStan\Type\MixedType();
    }
}
