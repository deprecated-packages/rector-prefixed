<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\Uid;

/**
 * @experimental in 5.2
 *
 * @author Gr√©goire Pineau <lyrixx@lyrixx.info>
 */
class Uuid extends \RectorPrefix20210408\Symfony\Component\Uid\AbstractUid
{
    protected const TYPE = 0;
    public function __construct(string $uuid)
    {
        $type = \uuid_is_valid($uuid) ? \uuid_type($uuid) : \false;
        if (\false === $type || \UUID_TYPE_INVALID === $type || (static::TYPE ?: $type) !== $type) {
            throw new \InvalidArgumentException(\sprintf('Invalid UUID%s: "%s".', static::TYPE ? 'v' . static::TYPE : '', $uuid));
        }
        $this->uid = \strtr($uuid, 'ABCDEF', 'abcdef');
    }
    /**
     * @return mixed
     */
    public static function fromString(string $uuid)
    {
        if (22 === \strlen($uuid) && 22 === \strspn($uuid, \RectorPrefix20210408\Symfony\Component\Uid\BinaryUtil::BASE58[''])) {
            $uuid = \RectorPrefix20210408\Symfony\Component\Uid\BinaryUtil::fromBase($uuid, \RectorPrefix20210408\Symfony\Component\Uid\BinaryUtil::BASE58);
        }
        if (16 === \strlen($uuid)) {
            // don't use uuid_unparse(), it's slower
            $uuid = \bin2hex($uuid);
            $uuid = \substr_replace($uuid, '-', 8, 0);
            $uuid = \substr_replace($uuid, '-', 13, 0);
            $uuid = \substr_replace($uuid, '-', 18, 0);
            $uuid = \substr_replace($uuid, '-', 23, 0);
        } elseif (26 === \strlen($uuid) && \RectorPrefix20210408\Symfony\Component\Uid\Ulid::isValid($uuid)) {
            $uuid = (new \RectorPrefix20210408\Symfony\Component\Uid\Ulid($uuid))->toRfc4122();
        }
        if (__CLASS__ !== static::class || 36 !== \strlen($uuid)) {
            return new static($uuid);
        }
        if (!\uuid_is_valid($uuid)) {
            throw new \InvalidArgumentException(\sprintf('Invalid UUID%s: "%s".', static::TYPE ? 'v' . static::TYPE : '', $uuid));
        }
        switch (\uuid_type($uuid)) {
            case \RectorPrefix20210408\Symfony\Component\Uid\UuidV1::TYPE:
                return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV1($uuid);
            case \RectorPrefix20210408\Symfony\Component\Uid\UuidV3::TYPE:
                return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV3($uuid);
            case \RectorPrefix20210408\Symfony\Component\Uid\UuidV4::TYPE:
                return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV4($uuid);
            case \RectorPrefix20210408\Symfony\Component\Uid\UuidV5::TYPE:
                return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV5($uuid);
            case \RectorPrefix20210408\Symfony\Component\Uid\UuidV6::TYPE:
                return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV6($uuid);
            case \RectorPrefix20210408\Symfony\Component\Uid\NilUuid::TYPE:
                return new \RectorPrefix20210408\Symfony\Component\Uid\NilUuid();
        }
        return new self($uuid);
    }
    public static final function v1() : \RectorPrefix20210408\Symfony\Component\Uid\UuidV1
    {
        return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV1();
    }
    /**
     * @param $this $namespace
     */
    public static final function v3($namespace, string $name) : \RectorPrefix20210408\Symfony\Component\Uid\UuidV3
    {
        // don't use uuid_generate_md5(), some versions are buggy
        $uuid = \md5(\hex2bin(\str_replace('-', '', $namespace->uid)) . $name, \true);
        return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV3(self::format($uuid, '-3'));
    }
    public static final function v4() : \RectorPrefix20210408\Symfony\Component\Uid\UuidV4
    {
        return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV4();
    }
    /**
     * @param $this $namespace
     */
    public static final function v5($namespace, string $name) : \RectorPrefix20210408\Symfony\Component\Uid\UuidV5
    {
        // don't use uuid_generate_sha1(), some versions are buggy
        $uuid = \substr(\sha1(\hex2bin(\str_replace('-', '', $namespace->uid)) . $name, \true), 0, 16);
        return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV5(self::format($uuid, '-5'));
    }
    public static final function v6() : \RectorPrefix20210408\Symfony\Component\Uid\UuidV6
    {
        return new \RectorPrefix20210408\Symfony\Component\Uid\UuidV6();
    }
    public static function isValid(string $uuid) : bool
    {
        if (__CLASS__ === static::class) {
            return \uuid_is_valid($uuid);
        }
        return \uuid_is_valid($uuid) && static::TYPE === \uuid_type($uuid);
    }
    public function toBinary() : string
    {
        return \uuid_parse($this->uid);
    }
    public function toRfc4122() : string
    {
        return $this->uid;
    }
    /**
     * @param \Symfony\Component\Uid\AbstractUid $other
     */
    public function compare($other) : int
    {
        if (\false !== ($cmp = \uuid_compare($this->uid, $other->uid))) {
            return $cmp;
        }
        return parent::compare($other);
    }
    private static function format(string $uuid, string $version) : string
    {
        $uuid[8] = $uuid[8] & "?" | "Ä";
        $uuid = \substr_replace(\bin2hex($uuid), '-', 8, 0);
        $uuid = \substr_replace($uuid, $version, 13, 1);
        $uuid = \substr_replace($uuid, '-', 18, 0);
        return \substr_replace($uuid, '-', 23, 0);
    }
}
