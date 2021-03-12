<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\PhpDocParser;

use PhpParser\Node\Param;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode;
use Rector\NodeNameResolver\NodeNameResolver;
final class ParamPhpDocNodeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node\Param $param) : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode($typeNode, $param->variadic, '$' . $this->nodeNameResolver->getName($param), '');
    }
}
