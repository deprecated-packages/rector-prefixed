<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

use RectorPrefix20201227\PHPStan\Analyser\NameScope;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
interface TypeNodeResolverExtension
{
    public const EXTENSION_TAG = 'phpstan.phpDoc.typeNodeResolverExtension';
    public function resolve(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \RectorPrefix20201227\PHPStan\Analyser\NameScope $nameScope) : ?\PHPStan\Type\Type;
}
