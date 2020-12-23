<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface TypeNodeResolverExtension
{
    public const EXTENSION_TAG = 'phpstan.phpDoc.typeNodeResolverExtension';
    public function resolve(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
