<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Throw_;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
final class ThrowAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function resolveThrownTypes(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Throw_ $throw) : array
    {
        $thrownType = $this->nodeTypeResolver->getStaticType($throw->expr);
        if ($thrownType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return [];
        }
        if ($thrownType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($thrownType->getTypes() as $unionedType) {
                $types[] = $this->resolveClassFromType($unionedType);
            }
            return $types;
        }
        $class = $this->resolveClassFromType($thrownType);
        return [$class];
    }
    private function resolveClassFromType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $thrownType) : string
    {
        if ($thrownType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return $thrownType->getFullyQualifiedName();
        }
        if ($thrownType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return $thrownType->getClassName();
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
    }
}
