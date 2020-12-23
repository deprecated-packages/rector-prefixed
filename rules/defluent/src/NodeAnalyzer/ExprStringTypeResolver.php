<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\NodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : ?string
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($expr);
        $exprStaticType = $this->typeUnwrapper->unwrapNullableType($exprStaticType);
        if (!$exprStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            // nothing we can do, unless
            return null;
        }
        if ($exprStaticType instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\AliasedObjectType) {
            return $exprStaticType->getFullyQualifiedClass();
        }
        return $exprStaticType->getClassName();
    }
}
