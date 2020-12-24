<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
class BenevolentUnionType extends \_PhpScopere8e811afab72\PHPStan\Type\UnionType
{
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return '(' . parent::describe($level) . ')';
    }
    protected function unionTypes(callable $getType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $resultTypes = [];
        foreach ($this->getTypes() as $type) {
            $result = $getType($type);
            if ($result instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                continue;
            }
            $resultTypes[] = $result;
        }
        if (\count($resultTypes) === 0) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$resultTypes);
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $types = [];
        $changed = \false;
        foreach ($this->getTypes() as $type) {
            $newType = $cb($type);
            if ($type !== $newType) {
                $changed = \true;
            }
            $types[] = $newType;
        }
        if ($changed) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::toBenevolentUnion(\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$types));
        }
        return $this;
    }
}
