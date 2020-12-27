<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
class BenevolentUnionType extends \PHPStan\Type\UnionType
{
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return '(' . parent::describe($level) . ')';
    }
    protected function unionTypes(callable $getType) : \PHPStan\Type\Type
    {
        $resultTypes = [];
        foreach ($this->getTypes() as $type) {
            $result = $getType($type);
            if ($result instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            $resultTypes[] = $result;
        }
        if (\count($resultTypes) === 0) {
            return new \PHPStan\Type\ErrorType();
        }
        return \PHPStan\Type\TypeCombinator::union(...$resultTypes);
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
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
            return \PHPStan\Type\TypeUtils::toBenevolentUnion(\PHPStan\Type\TypeCombinator::union(...$types));
        }
        return $this;
    }
}
