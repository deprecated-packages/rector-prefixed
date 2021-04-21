<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\ValueObject;

/**
 * @enum
 */
final class TypeStrictness
{
    /**
     * @var string
     */
    const STRICTNESS_TYPE_DECLARATION = 'type_declaration';
    /**
     * @var string
     */
    const STRICTNESS_DOCBLOCK = 'docblock';
}
