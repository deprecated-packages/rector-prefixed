<?php

declare(strict_types=1);

namespace Rector\DeadCode\PhpDoc;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\TypeComparator\TypeComparator;

final class DeadParamTagValueNodeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var TypeComparator
     */
    private $typeComparator;

    public function __construct(NodeNameResolver $nodeNameResolver, TypeComparator $typeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeComparator = $typeComparator;
    }

    public function isDead(ParamTagValueNode $paramTagValueNode, FunctionLike $functionLike): bool
    {
        $param = $this->matchParamByName($paramTagValueNode->parameterName, $functionLike);
        if (! $param instanceof Param) {
            return false;
        }

        if ($param->type === null) {
            return false;
        }

        if (! $this->typeComparator->arePhpParserAndPhpStanPhpDocTypesEqual(
            $param->type,
            $paramTagValueNode->type,
            $functionLike
        )) {
            return false;
        }

        if ($paramTagValueNode->type instanceof GenericTypeNode) {
            return false;
        }

        return $paramTagValueNode->description === '';
    }

    /**
     * @return \PhpParser\Node\Param|null
     */
    private function matchParamByName(string $desiredParamName, FunctionLike $functionLike)
    {
        foreach ($functionLike->getParams() as $param) {
            $paramName = $this->nodeNameResolver->getName($param);
            if ('$' . $paramName !== $desiredParamName) {
                continue;
            }

            return $param;
        }

        return null;
    }
}
