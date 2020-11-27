<?php

namespace _PhpScoper006a73f0e455;

interface SessionUpdateTimestampHandlerInterface
{
    /** @return bool */
    public function validateId(string $id);
    /** @return bool */
    public function updateTimestamp(string $id, string $data);
}
\class_alias('_PhpScoper006a73f0e455\\SessionUpdateTimestampHandlerInterface', 'SessionUpdateTimestampHandlerInterface', \false);
