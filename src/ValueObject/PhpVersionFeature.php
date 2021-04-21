<?php

declare(strict_types=1);

namespace Rector\Core\ValueObject;

final class PhpVersionFeature
{
    /**
     * @var int
     */
    const DIR_CONSTANT = PhpVersion::PHP_53;

    /**
     * @var int
     */
    const ELVIS_OPERATOR = PhpVersion::PHP_53;

    /**
     * @var int
     */
    const DATE_TIME_INTERFACE = PhpVersion::PHP_55;

    /**
     * @see https://wiki.php.net/rfc/class_name_scalars
     * @var int
     */
    const CLASSNAME_CONSTANT = PhpVersion::PHP_55;

    /**
     * @var int
     */
    const EXP_OPERATOR = PhpVersion::PHP_56;

    /**
     * @var int
     */
    const SCALAR_TYPES = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const NULL_COALESCE = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const LIST_SWAP_ORDER = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const SPACESHIP = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const DIRNAME_LEVELS = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const CSPRNG_FUNCTIONS = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const THROWABLE_TYPE = PhpVersion::PHP_70;

    /**
     * @var int
     */
    const ITERABLE_TYPE = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const VOID_TYPE = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const CONSTANT_VISIBILITY = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const ARRAY_DESTRUCT = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const MULTI_EXCEPTION_CATCH = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const OBJECT_TYPE = PhpVersion::PHP_72;

    /**
     * @var int
     */
    const IS_COUNTABLE = PhpVersion::PHP_73;

    /**
     * @var int
     */
    const ARRAY_KEY_FIRST_LAST = PhpVersion::PHP_73;

    /**
     * @var int
     */
    const JSON_EXCEPTION = PhpVersion::PHP_73;

    /**
     * @var int
     */
    const SETCOOKIE_ACCEPT_ARRAY_OPTIONS = PhpVersion::PHP_73;

    /**
     * @var int
     */
    const ARROW_FUNCTION = PhpVersion::PHP_74;

    /**
     * @var int
     */
    const LITERAL_SEPARATOR = PhpVersion::PHP_74;

    /**
     * @var int
     */
    const NULL_COALESCE_ASSIGN = PhpVersion::PHP_74;

    /**
     * @var int
     */
    const TYPED_PROPERTIES = PhpVersion::PHP_74;

    /**
     * @see https://wiki.php.net/rfc/covariant-returns-and-contravariant-parameters
     * @var int
     */
    const COVARIANT_RETURN = PhpVersion::PHP_74;

    /**
     * @var int
     */
    const ARRAY_SPREAD = PhpVersion::PHP_74;

    /**
     * @var int
     */
    const UNION_TYPES = PhpVersion::PHP_80;

    /**
     * @var int
     */
    const CLASS_ON_OBJECT = PhpVersion::PHP_80;

    /**
     * @var int
     */
    const STATIC_RETURN_TYPE = PhpVersion::PHP_80;

    /**
     * @var int
     */
    const IS_ITERABLE = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const NULLABLE_TYPE = PhpVersion::PHP_71;

    /**
     * @var int
     */
    const PARENT_VISIBILITY_OVERRIDE = PhpVersion::PHP_72;

    /**
     * @var int
     */
    const COUNT_ON_NULL = PhpVersion::PHP_71;

    /**
     * @see https://wiki.php.net/rfc/constructor_promotion
     * @var int
     */
    const PROPERTY_PROMOTION = PhpVersion::PHP_80;

    /**
     * @see https://wiki.php.net/rfc/attributes_v2
     * @var int
     */
    const ATTRIBUTES = PhpVersion::PHP_80;
}
