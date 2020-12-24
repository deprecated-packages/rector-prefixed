<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
class BenevolentUnionType extends \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType
{
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return '(' . parent::describe($level) . ')';
    }
    protected function unionTypes(callable $getType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $resultTypes = [];
        foreach ($this->getTypes() as $type) {
            $result = $getType($type);
            if ($result instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
                continue;
            }
            $resultTypes[] = $result;
        }
        if (\count($resultTypes) === 0) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
        }
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$resultTypes);
    }
    public function isAcceptedBy(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function traverse(callable $cb) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
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
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::toBenevolentUnion(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$types));
        }
        return $this;
    }
}
