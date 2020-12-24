<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface TemplateType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType
{
    public function getName() : string;
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeScope;
    public function getBound() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function toArgument() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType;
    public function isArgument() : bool;
    public function isValidVariance(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $a, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $b) : bool;
    public function getVariance() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
}
