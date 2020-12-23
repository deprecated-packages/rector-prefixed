<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
final class ReturnTypeInferer extends \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\AbstractPriorityAwareTypeInferer
{
    /**
     * @var ReturnTypeInfererInterface[]
     */
    private $returnTypeInferers = [];
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    /**
     * @param ReturnTypeInfererInterface[] $returnTypeInferers
     */
    public function __construct(array $returnTypeInferers, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer)
    {
        $this->returnTypeInferers = $this->sortTypeInferersByPriority($returnTypeInferers);
        $this->typeNormalizer = $typeNormalizer;
    }
    public function inferFunctionLike(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->inferFunctionLikeWithExcludedInferers($functionLike, []);
    }
    /**
     * @param string[] $excludedInferers
     */
    public function inferFunctionLikeWithExcludedInferers(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $functionLike, array $excludedInferers) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        foreach ($this->returnTypeInferers as $returnTypeInferer) {
            if ($this->shouldSkipExcludedTypeInferer($returnTypeInferer, $excludedInferers)) {
                continue;
            }
            $originalType = $returnTypeInferer->inferFunctionLike($functionLike);
            if ($originalType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
                continue;
            }
            $type = $this->typeNormalizer->normalizeArrayTypeAndArrayNever($originalType);
            $type = $this->typeNormalizer->uniqueateConstantArrayType($type);
            // in case of void, check return type of children methods
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    /**
     * @param string[] $excludedInferers
     */
    private function shouldSkipExcludedTypeInferer(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface $returnTypeInferer, array $excludedInferers) : bool
    {
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsAOf($excludedInferers, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface::class);
        foreach ($excludedInferers as $excludedInferer) {
            if (\is_a($returnTypeInferer, $excludedInferer)) {
                return \true;
            }
        }
        return \false;
    }
}
