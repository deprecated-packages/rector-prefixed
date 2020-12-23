<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Parser;

use _PhpScoper0a2ac50786fa\PhpParser\ErrorHandler;
class PhpParserDecorator implements \_PhpScoper0a2ac50786fa\PhpParser\Parser
{
    /** @var \PHPStan\Parser\Parser */
    private $wrappedParser;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\_PhpScoper0a2ac50786fa\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\_PhpScoper0a2ac50786fa\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \_PhpScoper0a2ac50786fa\PhpParser\Error($message);
        }
    }
}
