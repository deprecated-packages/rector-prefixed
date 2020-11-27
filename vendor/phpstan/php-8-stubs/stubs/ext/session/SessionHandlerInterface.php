<?php

namespace _PhpScopera143bcca66cb;

interface SessionHandlerInterface
{
    /** @return bool */
    public function open(string $path, string $name);
    /** @return bool */
    public function close();
    /** @return string */
    public function read(string $id);
    /** @return bool */
    public function write(string $id, string $data);
    /** @return bool */
    public function destroy(string $id);
    /** @return int|bool */
    public function gc(int $max_lifetime);
}
\class_alias('_PhpScopera143bcca66cb\\SessionHandlerInterface', 'SessionHandlerInterface', \false);
