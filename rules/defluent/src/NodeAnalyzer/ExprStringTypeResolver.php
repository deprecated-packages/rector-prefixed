<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
final class ExprStringTypeResolver
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?string
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($expr);
        $exprStaticType = $this->typeUnwrapper->unwrapNullableType($exprStaticType);
        if (!$exprStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            // nothing we can do, unless
            return null;
        }
        if ($exprStaticType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType) {
            return $exprStaticType->getFullyQualifiedClass();
        }
        return $exprStaticType->getClassName();
    }
}
