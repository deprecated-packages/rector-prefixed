<?php

namespace _PhpScoper26e51eeacccf;

/**
 * @param string $output
 * @param OpenSSLAsymmetricKey|OpenSSLCertificate|array|string $private_key
 */
function openssl_pkcs12_export(\OpenSSLCertificate|string $certificate, &$output, $private_key, string $passphrase, array $options = []) : bool
{
}
