<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?string
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($expr);
        $exprStaticType = $this->typeUnwrapper->unwrapNullableType($exprStaticType);
        if (!$exprStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            // nothing we can do, unless
            return null;
        }
        if ($exprStaticType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType) {
            return $exprStaticType->getFullyQualifiedClass();
        }
        return $exprStaticType->getClassName();
    }
}
