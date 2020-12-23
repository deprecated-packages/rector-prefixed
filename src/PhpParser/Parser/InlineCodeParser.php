<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\Encapsed;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\Parser;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScoper0a2ac50786fa\PhpParser\Parser $parser)
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
        $content = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::startsWith($content, '<?php ') ? $content : '<?php ' . $content;
        $content = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($content, ';') ? $content : $content . ';';
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
        if ($content instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return $content->value;
        }
        if ($content instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\Encapsed) {
            // remove "
            $content = \trim($this->betterStandardPrinter->print($content), '""');
            // use \$ → $
            $content = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($content, self::PRESLASHED_DOLLAR_REGEX, '$');
            // use \'{$...}\' → $...
            return \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($content, self::CURLY_BRACKET_WRAPPER_REGEX, '$1');
        }
        if ($content instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->stringify($content->left) . $this->stringify($content->right);
        }
        if ($content instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable || $content instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch || $content instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
            return $this->betterStandardPrinter->print($content);
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException(\get_class($content) . ' ' . __METHOD__);
    }
}
