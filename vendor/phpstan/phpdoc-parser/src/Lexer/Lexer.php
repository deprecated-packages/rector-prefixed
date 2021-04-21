<?php

declare (strict_types=1);
namespace PHPStan\PhpDocParser\Lexer;

/**
 * Implementation based on Nette Tokenizer (New BSD License; https://github.com/nette/tokenizer)
 */
class Lexer
{
    const TOKEN_REFERENCE = 0;
    const TOKEN_UNION = 1;
    const TOKEN_INTERSECTION = 2;
    const TOKEN_NULLABLE = 3;
    const TOKEN_OPEN_PARENTHESES = 4;
    const TOKEN_CLOSE_PARENTHESES = 5;
    const TOKEN_OPEN_ANGLE_BRACKET = 6;
    const TOKEN_CLOSE_ANGLE_BRACKET = 7;
    const TOKEN_OPEN_SQUARE_BRACKET = 8;
    const TOKEN_CLOSE_SQUARE_BRACKET = 9;
    const TOKEN_COMMA = 10;
    const TOKEN_VARIADIC = 11;
    const TOKEN_DOUBLE_COLON = 12;
    const TOKEN_DOUBLE_ARROW = 13;
    const TOKEN_EQUAL = 14;
    const TOKEN_OPEN_PHPDOC = 15;
    const TOKEN_CLOSE_PHPDOC = 16;
    const TOKEN_PHPDOC_TAG = 17;
    const TOKEN_FLOAT = 18;
    const TOKEN_INTEGER = 19;
    const TOKEN_SINGLE_QUOTED_STRING = 20;
    const TOKEN_DOUBLE_QUOTED_STRING = 21;
    const TOKEN_IDENTIFIER = 22;
    const TOKEN_THIS_VARIABLE = 23;
    const TOKEN_VARIABLE = 24;
    const TOKEN_HORIZONTAL_WS = 25;
    const TOKEN_PHPDOC_EOL = 26;
    const TOKEN_OTHER = 27;
    const TOKEN_END = 28;
    const TOKEN_COLON = 29;
    const TOKEN_WILDCARD = 30;
    const TOKEN_OPEN_CURLY_BRACKET = 31;
    const TOKEN_CLOSE_CURLY_BRACKET = 32;
    const TOKEN_LABELS = [self::TOKEN_REFERENCE => '\'&\'', self::TOKEN_UNION => '\'|\'', self::TOKEN_INTERSECTION => '\'&\'', self::TOKEN_NULLABLE => '\'?\'', self::TOKEN_OPEN_PARENTHESES => '\'(\'', self::TOKEN_CLOSE_PARENTHESES => '\')\'', self::TOKEN_OPEN_ANGLE_BRACKET => '\'<\'', self::TOKEN_CLOSE_ANGLE_BRACKET => '\'>\'', self::TOKEN_OPEN_SQUARE_BRACKET => '\'[\'', self::TOKEN_CLOSE_SQUARE_BRACKET => '\']\'', self::TOKEN_OPEN_CURLY_BRACKET => '\'{\'', self::TOKEN_CLOSE_CURLY_BRACKET => '\'}\'', self::TOKEN_COMMA => '\',\'', self::TOKEN_COLON => '\':\'', self::TOKEN_VARIADIC => '\'...\'', self::TOKEN_DOUBLE_COLON => '\'::\'', self::TOKEN_DOUBLE_ARROW => '\'=>\'', self::TOKEN_EQUAL => '\'=\'', self::TOKEN_OPEN_PHPDOC => '\'/**\'', self::TOKEN_CLOSE_PHPDOC => '\'*/\'', self::TOKEN_PHPDOC_TAG => 'TOKEN_PHPDOC_TAG', self::TOKEN_PHPDOC_EOL => 'TOKEN_PHPDOC_EOL', self::TOKEN_FLOAT => 'TOKEN_FLOAT', self::TOKEN_INTEGER => 'TOKEN_INTEGER', self::TOKEN_SINGLE_QUOTED_STRING => 'TOKEN_SINGLE_QUOTED_STRING', self::TOKEN_DOUBLE_QUOTED_STRING => 'TOKEN_DOUBLE_QUOTED_STRING', self::TOKEN_IDENTIFIER => 'type', self::TOKEN_THIS_VARIABLE => '\'$this\'', self::TOKEN_VARIABLE => 'variable', self::TOKEN_HORIZONTAL_WS => 'TOKEN_HORIZONTAL_WS', self::TOKEN_OTHER => 'TOKEN_OTHER', self::TOKEN_END => 'TOKEN_END', self::TOKEN_WILDCARD => '*'];
    const VALUE_OFFSET = 0;
    const TYPE_OFFSET = 1;
    /** @var string|null */
    private $regexp;
    /** @var int[]|null */
    private $types;
    public function tokenize(string $s) : array
    {
        if ($this->regexp === null || $this->types === null) {
            $this->initialize();
        }
        \assert($this->regexp !== null);
        \assert($this->types !== null);
        \preg_match_all($this->regexp, $s, $tokens, \PREG_SET_ORDER);
        $count = \count($this->types);
        foreach ($tokens as &$match) {
            for ($i = 1; $i <= $count; $i++) {
                if ($match[$i] !== null && $match[$i] !== '') {
                    $match = [$match[0], $this->types[$i - 1]];
                    break;
                }
            }
        }
        $tokens[] = ['', self::TOKEN_END];
        return $tokens;
    }
    /**
     * @return void
     */
    private function initialize()
    {
        $patterns = [
            // '&' followed by TOKEN_VARIADIC, TOKEN_VARIABLE, TOKEN_EQUAL, TOKEN_EQUAL or TOKEN_CLOSE_PARENTHESES
            self::TOKEN_REFERENCE => '&(?=\\s*+(?:[.,=)]|(?:\\$(?!this(?![0-9a-z_\\x80-\\xFF])))))',
            self::TOKEN_UNION => '\\|',
            self::TOKEN_INTERSECTION => '&',
            self::TOKEN_NULLABLE => '\\?',
            self::TOKEN_OPEN_PARENTHESES => '\\(',
            self::TOKEN_CLOSE_PARENTHESES => '\\)',
            self::TOKEN_OPEN_ANGLE_BRACKET => '<',
            self::TOKEN_CLOSE_ANGLE_BRACKET => '>',
            self::TOKEN_OPEN_SQUARE_BRACKET => '\\[',
            self::TOKEN_CLOSE_SQUARE_BRACKET => '\\]',
            self::TOKEN_OPEN_CURLY_BRACKET => '\\{',
            self::TOKEN_CLOSE_CURLY_BRACKET => '\\}',
            self::TOKEN_COMMA => ',',
            self::TOKEN_VARIADIC => '\\.\\.\\.',
            self::TOKEN_DOUBLE_COLON => '::',
            self::TOKEN_DOUBLE_ARROW => '=>',
            self::TOKEN_EQUAL => '=',
            self::TOKEN_COLON => ':',
            self::TOKEN_OPEN_PHPDOC => '/\\*\\*(?=\\s)\\x20?+',
            self::TOKEN_CLOSE_PHPDOC => '\\*/',
            self::TOKEN_PHPDOC_TAG => '@[a-z][a-z0-9-]*+',
            self::TOKEN_PHPDOC_EOL => '\\r?+\\n[\\x09\\x20]*+(?:\\*(?!/)\\x20?+)?',
            self::TOKEN_FLOAT => '(?:-?[0-9]++\\.[0-9]*+(?:e-?[0-9]++)?)|(?:-?[0-9]*+\\.[0-9]++(?:e-?[0-9]++)?)|(?:-?[0-9]++e-?[0-9]++)',
            self::TOKEN_INTEGER => '-?(?:(?:0b[0-1]++)|(?:0o[0-7]++)|(?:0x[0-9a-f]++)|(?:[0-9]++))',
            self::TOKEN_SINGLE_QUOTED_STRING => '\'(?:\\\\[^\\r\\n]|[^\'\\r\\n\\\\])*+\'',
            self::TOKEN_DOUBLE_QUOTED_STRING => '"(?:\\\\[^\\r\\n]|[^"\\r\\n\\\\])*+"',
            self::TOKEN_IDENTIFIER => '(?:[\\\\]?+[a-z_\\x80-\\xFF][0-9a-z_\\x80-\\xFF-]*+)++',
            self::TOKEN_THIS_VARIABLE => '\\$this(?![0-9a-z_\\x80-\\xFF])',
            self::TOKEN_VARIABLE => '\\$[a-z_\\x80-\\xFF][0-9a-z_\\x80-\\xFF]*+',
            self::TOKEN_HORIZONTAL_WS => '[\\x09\\x20]++',
            self::TOKEN_WILDCARD => '\\*',
            // anything but TOKEN_CLOSE_PHPDOC or TOKEN_HORIZONTAL_WS or TOKEN_EOL
            self::TOKEN_OTHER => '(?:(?!\\*/)[^\\s])++',
        ];
        $this->regexp = '~(' . \implode(')|(', $patterns) . ')~Asi';
        $this->types = \array_keys($patterns);
    }
}
