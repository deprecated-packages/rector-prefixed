<?php

namespace _PhpScoper006a73f0e455\React\Dns\Query;

use _PhpScoper006a73f0e455\React\Dns\Config\HostsFile;
use _PhpScoper006a73f0e455\React\Dns\Model\Message;
use _PhpScoper006a73f0e455\React\Dns\Model\Record;
use _PhpScoper006a73f0e455\React\Promise;
/**
 * Resolves hosts from the given HostsFile or falls back to another executor
 *
 * If the host is found in the hosts file, it will not be passed to the actual
 * DNS executor. If the host is not found in the hosts file, it will be passed
 * to the DNS executor as a fallback.
 */
final class HostsFileExecutor implements \_PhpScoper006a73f0e455\React\Dns\Query\ExecutorInterface
{
    private $hosts;
    private $fallback;
    public function __construct(\_PhpScoper006a73f0e455\React\Dns\Config\HostsFile $hosts, \_PhpScoper006a73f0e455\React\Dns\Query\ExecutorInterface $fallback)
    {
        $this->hosts = $hosts;
        $this->fallback = $fallback;
    }
    public function query(\_PhpScoper006a73f0e455\React\Dns\Query\Query $query)
    {
        if ($query->class === \_PhpScoper006a73f0e455\React\Dns\Model\Message::CLASS_IN && ($query->type === \_PhpScoper006a73f0e455\React\Dns\Model\Message::TYPE_A || $query->type === \_PhpScoper006a73f0e455\React\Dns\Model\Message::TYPE_AAAA)) {
            // forward lookup for type A or AAAA
            $records = array();
            $expectsColon = $query->type === \_PhpScoper006a73f0e455\React\Dns\Model\Message::TYPE_AAAA;
            foreach ($this->hosts->getIpsForHost($query->name) as $ip) {
                // ensure this is an IPv4/IPV6 address according to query type
                if ((\strpos($ip, ':') !== \false) === $expectsColon) {
                    $records[] = new \_PhpScoper006a73f0e455\React\Dns\Model\Record($query->name, $query->type, $query->class, 0, $ip);
                }
            }
            if ($records) {
                return \_PhpScoper006a73f0e455\React\Promise\resolve(\_PhpScoper006a73f0e455\React\Dns\Model\Message::createResponseWithAnswersForQuery($query, $records));
            }
        } elseif ($query->class === \_PhpScoper006a73f0e455\React\Dns\Model\Message::CLASS_IN && $query->type === \_PhpScoper006a73f0e455\React\Dns\Model\Message::TYPE_PTR) {
            // reverse lookup: extract IPv4 or IPv6 from special `.arpa` domain
            $ip = $this->getIpFromHost($query->name);
            if ($ip !== null) {
                $records = array();
                foreach ($this->hosts->getHostsForIp($ip) as $host) {
                    $records[] = new \_PhpScoper006a73f0e455\React\Dns\Model\Record($query->name, $query->type, $query->class, 0, $host);
                }
                if ($records) {
                    return \_PhpScoper006a73f0e455\React\Promise\resolve(\_PhpScoper006a73f0e455\React\Dns\Model\Message::createResponseWithAnswersForQuery($query, $records));
                }
            }
        }
        return $this->fallback->query($query);
    }
    private function getIpFromHost($host)
    {
        if (\substr($host, -13) === '.in-addr.arpa') {
            // IPv4: read as IP and reverse bytes
            $ip = @\inet_pton(\substr($host, 0, -13));
            if ($ip === \false || isset($ip[4])) {
                return null;
            }
            return \inet_ntop(\strrev($ip));
        } elseif (\substr($host, -9) === '.ip6.arpa') {
            // IPv6: replace dots, reverse nibbles and interpret as hexadecimal string
            $ip = @\inet_ntop(\pack('H*', \strrev(\str_replace('.', '', \substr($host, 0, -9)))));
            if ($ip === \false) {
                return null;
            }
            return $ip;
        } else {
            return null;
        }
    }
}
