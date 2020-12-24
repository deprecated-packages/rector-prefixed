<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
final class InlineCodeParser
{
    /**
     * @var string
     * @see https://regex101.com/r/dwe4OW/1
     */
    private const PRESLASHED_DOLLAR_REGEX = '#\\\\\\$#';
    /**
     * @var string
     * @see https://regex101.com/r/tvwhWq/1
     */
    private const CURLY_BRACKET_WRAPPER_REGEX = "#'{(\\\$.*?)}'#";
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeScopeAndMetadataDecorator
     */
    private $nodeScopeAndMetadataDecorator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScopere8e811afab72\PhpParser\Parser $parser)
    {
        $this->parser = $parser;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
    }
    /**
     * @return Stmt[]
     */
    public function parse(string $content) : array
    {
        // wrap code so php-parser can interpret it
        $content = \_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($content, '<?php ') ? $content : '<?php ' . $content;
        $content = \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($content, ';') ? $content : $content . ';';
        $nodes = (array) $this->parser->parse($content);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromString($nodes);
    }
    /**
     * @param string|Node $content
     */
    public function stringify($content) : string
    {
        if (\is_string($content)) {
            return $content;
        }
        if ($content instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $content->value;
        }
        if ($content instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed) {
            // remove "
            $content = \trim($this->betterStandardPrinter->print($content), '""');
            // use \$ → $
            $content = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($content, self::PRESLASHED_DOLLAR_REGEX, '$');
            // use \'{$...}\' → $...
            return \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($content, self::CURLY_BRACKET_WRAPPER_REGEX, '$1');
        }
        if ($content instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->stringify($content->left) . $this->stringify($content->right);
        }
        if ($content instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || $content instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch || $content instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return $this->betterStandardPrinter->print($content);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\get_class($content) . ' ' . __METHOD__);
    }
}
