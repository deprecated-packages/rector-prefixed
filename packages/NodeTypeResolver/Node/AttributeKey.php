<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Node;

use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class AttributeKey
{
    /**
     * @var string
     */
    public const VIRTUAL_NODE = 'virtual_node';
    /**
     * @var string
     */
    public const SCOPE = \PHPStan\Analyser\Scope::class;
    /**
     * @var string
     */
    public const USE_NODES = 'useNodes';
    /**
     * @var string
     */
    public const CLASS_NAME = 'className';
    /**
     * @var string
     */
    public const CLASS_NODE = \PhpParser\Node\Stmt\ClassLike::class;
    /**
     * @var string
     */
    public const METHOD_NAME = 'methodName';
    /**
     * @var string
     */
    public const METHOD_NODE = 'methodNode';
    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    public const ORIGINAL_NODE = 'origNode';
    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    public const COMMENTS = 'comments';
    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    public const ORIGINAL_NAME = 'originalName';
    /**
     * Internal php-parser name. @see \PhpParser\NodeVisitor\NameResolver
     * Do not change this even if you want!
     *
     * @var string
     */
    public const RESOLVED_NAME = 'resolvedName';
    /**
     * @internal of php-parser, do not change
     * @see https://github.com/nikic/PHP-Parser/pull/681/files
     * @var string
     */
    public const PARENT_NODE = 'parent';
    /**
     * @internal of php-parser, do not change
     * @see https://github.com/nikic/PHP-Parser/pull/681/files
     * @var string
     */
    public const PREVIOUS_NODE = 'previous';
    /**
     * @internal of php-parser, do not change
     * @see https://github.com/nikic/PHP-Parser/pull/681/files
     * @var string
     */
    public const NEXT_NODE = 'next';
    /**
     * @var string
     */
    public const PREVIOUS_STATEMENT = 'previousExpression';
    /**
     * @var string
     */
    public const CURRENT_STATEMENT = 'currentExpression';
    /**
     * @var string
     */
    public const FILE_INFO = \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo::class;
    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    public const NAMESPACED_NAME = 'namespacedName';
    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    public const DOC_INDENTATION = 'docIndentation';
    /**
     * Internal php-parser name.
     * Do not change this even if you want!
     *
     * @var string
     */
    public const START_TOKEN_POSITION = 'startTokenPos';
    /**
     * @var string
     * Use often in php-parser
     */
    public const KIND = 'kind';
    /**
     * @var string
     */
    public const IS_UNREACHABLE = 'isUnreachable';
    /**
     * @var string
     */
    public const PHP_DOC_INFO = \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo::class;
    /**
     * @var string
     */
    public const IS_REGULAR_PATTERN = 'is_regular_pattern';
    /**
     * @var string
     */
    public const DO_NOT_CHANGE = 'do_not_change';
    /**
     * @var string
     */
    public const PARAMETER_POSITION = 'parameter_position';
    /**
     * @var string
     */
    public const ARGUMENT_POSITION = 'argument_position';
    /**
     * @var string
     */
    public const FUNC_ARGS_TRAILING_COMMA = 'trailing_comma';
}
