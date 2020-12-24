<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Parser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler;
class PhpParserDecorator implements \_PhpScoper2a4e7ab1ecbc\PhpParser\Parser
{
    /** @var \PHPStan\Parser\Parser */
    private $wrappedParser;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\_PhpScoper2a4e7ab1ecbc\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\_PhpScoper2a4e7ab1ecbc\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \_PhpScoper2a4e7ab1ecbc\PhpParser\Error($message);
        }
    }
}
