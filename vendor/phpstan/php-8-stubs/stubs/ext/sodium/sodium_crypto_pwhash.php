<?php

namespace _PhpScoper88fe6e0ad041;

#ifdef crypto_pwhash_SALTBYTES
function sodium_crypto_pwhash(int $length, string $password, string $salt, int $opslimit, int $memlimit, int $algo = \SODIUM_CRYPTO_PWHASH_ALG_DEFAULT) : string
{
}