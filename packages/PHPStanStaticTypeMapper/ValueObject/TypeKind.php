<?php

declare(strict_types=1);

namespace Rector\PHPStanStaticTypeMapper\ValueObject;

final class TypeKind
{
    /**
     * @var string
     */
    const KIND_PROPERTY = 'property';

    /**
     * @var string
     */
    const KIND_RETURN = 'return';

    /**
     * @var string
     */
    const KIND_PARAM = 'param';
}
