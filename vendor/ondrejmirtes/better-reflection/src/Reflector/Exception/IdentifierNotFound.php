<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Exception;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier;
use RuntimeException;
use function sprintf;
class IdentifierNotFound extends \RuntimeException
{
    /** @var Identifier */
    private $identifier;
    public function __construct(string $message, \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier)
    {
        parent::__construct($message);
        $this->identifier = $identifier;
    }
    public function getIdentifier() : \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier
    {
        return $this->identifier;
    }
    public static function fromIdentifier(\_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : self
    {
        return new self(\sprintf('%s "%s" could not be found in the located source', $identifier->getType()->getName(), $identifier->getName()), $identifier);
    }
}
