<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
class BenevolentUnionType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType
{
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return '(' . parent::describe($level) . ')';
    }
    protected function unionTypes(callable $getType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $resultTypes = [];
        foreach ($this->getTypes() as $type) {
            $result = $getType($type);
            if ($result instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
                continue;
            }
            $resultTypes[] = $result;
        }
        if (\count($resultTypes) === 0) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...$resultTypes);
    }
    public function isAcceptedBy(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function traverse(callable $cb) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::toBenevolentUnion(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...$types));
        }
        return $this;
    }
}
