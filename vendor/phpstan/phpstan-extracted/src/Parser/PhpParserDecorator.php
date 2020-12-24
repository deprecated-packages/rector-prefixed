<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Parser;

use _PhpScoper0a6b37af0871\PhpParser\ErrorHandler;
class PhpParserDecorator implements \_PhpScoper0a6b37af0871\PhpParser\Parser
{
    /** @var \PHPStan\Parser\Parser */
    private $wrappedParser;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\_PhpScoper0a6b37af0871\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\_PhpScoper0a6b37af0871\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \_PhpScoper0a6b37af0871\PhpParser\Error($message);
        }
    }
}
