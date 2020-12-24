<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
final class ReturnTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractPriorityAwareTypeInferer
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
    public function __construct(array $returnTypeInferers, \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer)
    {
        $this->returnTypeInferers = $this->sortTypeInferersByPriority($returnTypeInferers);
        $this->typeNormalizer = $typeNormalizer;
    }
    public function inferFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->inferFunctionLikeWithExcludedInferers($functionLike, []);
    }
    /**
     * @param string[] $excludedInferers
     */
    public function inferFunctionLikeWithExcludedInferers(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, array $excludedInferers) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        foreach ($this->returnTypeInferers as $returnTypeInferer) {
            if ($this->shouldSkipExcludedTypeInferer($returnTypeInferer, $excludedInferers)) {
                continue;
            }
            $originalType = $returnTypeInferer->inferFunctionLike($functionLike);
            if ($originalType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                continue;
            }
            $type = $this->typeNormalizer->normalizeArrayTypeAndArrayNever($originalType);
            $type = $this->typeNormalizer->uniqueateConstantArrayType($type);
            // in case of void, check return type of children methods
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    /**
     * @param string[] $excludedInferers
     */
    private function shouldSkipExcludedTypeInferer(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface $returnTypeInferer, array $excludedInferers) : bool
    {
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsAOf($excludedInferers, \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface::class);
        foreach ($excludedInferers as $excludedInferer) {
            if (\is_a($returnTypeInferer, $excludedInferer)) {
                return \true;
            }
        }
        return \false;
    }
}
