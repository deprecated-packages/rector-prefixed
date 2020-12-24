<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
final class ThrowAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function resolveThrownTypes(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_ $throw) : array
    {
        $thrownType = $this->nodeTypeResolver->getStaticType($throw->expr);
        if ($thrownType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return [];
        }
        if ($thrownType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($thrownType->getTypes() as $unionedType) {
                $types[] = $this->resolveClassFromType($unionedType);
            }
            return $types;
        }
        $class = $this->resolveClassFromType($thrownType);
        return [$class];
    }
    private function resolveClassFromType(\_PhpScopere8e811afab72\PHPStan\Type\Type $thrownType) : string
    {
        if ($thrownType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return $thrownType->getFullyQualifiedName();
        }
        if ($thrownType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return $thrownType->getClassName();
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
}
