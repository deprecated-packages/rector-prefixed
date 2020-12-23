<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
}
