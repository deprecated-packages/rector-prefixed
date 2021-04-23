<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Parser;

use RectorPrefix20210423\Nette\Utils\Strings;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\Encapsed;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Parser;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use RectorPrefix20210423\Symplify\SmartFileSystem\SmartFileSystem;
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
     * @var string
     * @see https://regex101.com/r/TBlhoR/1
     */
    private const OPEN_PHP_TAG_REGEX = '#^\\<\\?php\\s+#';
    /**
     * @var string
     * @see https://regex101.com/r/TUWwKw/1/
     */
    private const ENDING_SEMI_COLON_REGEX = '#;(\\s+)?$#';
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var NodeScopeAndMetadataDecorator
     */
    private $nodeScopeAndMetadataDecorator;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \PhpParser\Parser $parser, \RectorPrefix20210423\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->parser = $parser;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return Stmt[]
     */
    public function parse(string $content) : array
    {
        // to cover files too
        if (\is_file($content)) {
            $content = $this->smartFileSystem->readFile($content);
        }
        // wrap code so php-parser can interpret it
        $content = \RectorPrefix20210423\Nette\Utils\Strings::match($content, self::OPEN_PHP_TAG_REGEX) ? $content : '<?php ' . $content;
        $content = \RectorPrefix20210423\Nette\Utils\Strings::match($content, self::ENDING_SEMI_COLON_REGEX) ? $content : $content . ';';
        $nodes = (array) $this->parser->parse($content);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromString($nodes);
    }
    public function stringify(\PhpParser\Node\Expr $expr) : string
    {
        if ($expr instanceof \PhpParser\Node\Scalar\String_) {
            return $expr->value;
        }
        if ($expr instanceof \PhpParser\Node\Scalar\Encapsed) {
            // remove "
            $expr = \trim($this->betterStandardPrinter->print($expr), '""');
            // use \$ → $
            $expr = \RectorPrefix20210423\Nette\Utils\Strings::replace($expr, self::PRESLASHED_DOLLAR_REGEX, '$');
            // use \'{$...}\' → $...
            return \RectorPrefix20210423\Nette\Utils\Strings::replace($expr, self::CURLY_BRACKET_WRAPPER_REGEX, '$1');
        }
        if ($expr instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
            return $this->stringify($expr->left) . $this->stringify($expr->right);
        }
        if ($expr instanceof \PhpParser\Node\Expr\Variable || $expr instanceof \PhpParser\Node\Expr\PropertyFetch || $expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return $this->betterStandardPrinter->print($expr);
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException(\get_class($expr) . ' ' . __METHOD__);
    }
}
