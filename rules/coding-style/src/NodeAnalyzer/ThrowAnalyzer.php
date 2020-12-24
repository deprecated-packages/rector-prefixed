<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Throw_;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
final class ThrowAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function resolveThrownTypes(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Throw_ $throw) : array
    {
        $thrownType = $this->nodeTypeResolver->getStaticType($throw->expr);
        if ($thrownType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return [];
        }
        if ($thrownType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($thrownType->getTypes() as $unionedType) {
                $types[] = $this->resolveClassFromType($unionedType);
            }
            return $types;
        }
        $class = $this->resolveClassFromType($thrownType);
        return [$class];
    }
    private function resolveClassFromType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $thrownType) : string
    {
        if ($thrownType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return $thrownType->getFullyQualifiedName();
        }
        if ($thrownType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return $thrownType->getClassName();
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
    }
}
