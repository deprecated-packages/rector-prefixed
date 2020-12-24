<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\Analyser\NameScope;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface TypeNodeResolverExtension
{
    public const EXTENSION_TAG = 'phpstan.phpDoc.typeNodeResolverExtension';
    public function resolve(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type;
}
