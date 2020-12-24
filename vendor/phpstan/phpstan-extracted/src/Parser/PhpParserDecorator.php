<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Parser;

use _PhpScoperb75b35f52b74\PhpParser\ErrorHandler;
class PhpParserDecorator implements \_PhpScoperb75b35f52b74\PhpParser\Parser
{
    /** @var \PHPStan\Parser\Parser */
    private $wrappedParser;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\_PhpScoperb75b35f52b74\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\_PhpScoperb75b35f52b74\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \_PhpScoperb75b35f52b74\PhpParser\Error($message);
        }
    }
}
