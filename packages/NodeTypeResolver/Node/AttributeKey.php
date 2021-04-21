<?php

declare(strict_types=1);

namespace Rector\NodeTypeResolver\Node;

use Symplify\SmartFileSystem\SmartFileInfo;

final class AttributeKey
{
    /**
     * @var string
     */
    const VIRTUAL_NODE = 'virtual_node';

    /**
     * @var string
     */
    const SCOPE = 'scope';

    /**
     * @var string
     */
    const USE_NODES = 'useNodes';

    /**
     * @var string
     */
    const CLASS_NAME = 'className';

    /**
     * @var string
     */
    const CLASS_NODE = 'class_node';

    /**
     * @var string
     */
    const METHOD_NAME = 'methodName';

    /**
     * @var string
     */
    const METHOD_NODE = 'methodNode';

    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    const ORIGINAL_NODE = 'origNode';

    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    const COMMENTS = 'comments';

    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    const ORIGINAL_NAME = 'originalName';

    /**
     * Internal php-parser name. @see \PhpParser\NodeVisitor\NameResolver
     * Do not change this even if you want!
     *
     * @var string
     */
    const RESOLVED_NAME = 'resolvedName';

    /**
     * @internal of php-parser, do not change
     * @see https://github.com/nikic/PHP-Parser/pull/681/files
     * @var string
     */
    const PARENT_NODE = 'parent';

    /**
     * @internal of php-parser, do not change
     * @see https://github.com/nikic/PHP-Parser/pull/681/files
     * @var string
     */
    const PREVIOUS_NODE = 'previous';

    /**
     * @internal of php-parser, do not change
     * @see https://github.com/nikic/PHP-Parser/pull/681/files
     * @var string
     */
    const NEXT_NODE = 'next';

    /**
     * @var string
     */
    const PREVIOUS_STATEMENT = 'previousExpression';

    /**
     * @var string
     */
    const CURRENT_STATEMENT = 'currentExpression';

    /**
     * @deprecated Use File object instead, e.g. via CurrentFileProvider
     * @var string
     */
    const FILE_INFO = SmartFileInfo::class;

    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    const NAMESPACED_NAME = 'namespacedName';

    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    const DOC_INDENTATION = 'docIndentation';

    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    const START_TOKEN_POSITION = 'startTokenPos';

    /**
     * @var string
     * Use often in php-parser
     */
    const KIND = 'kind';

    /**
     * @var string
     */
    const IS_UNREACHABLE = 'isUnreachable';

    /**
     * @var string
     */
    const PHP_DOC_INFO = 'php_doc_info';

    /**
     * @var string
     */
    const IS_REGULAR_PATTERN = 'is_regular_pattern';

    /**
     * @var string
     */
    const DO_NOT_CHANGE = 'do_not_change';

    /**
     * @var string
     */
    const PARAMETER_POSITION = 'parameter_position';

    /**
     * @var string
     */
    const ARGUMENT_POSITION = 'argument_position';

    /**
     * @var string
     */
    const FUNC_ARGS_TRAILING_COMMA = 'trailing_comma';
}
