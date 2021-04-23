<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210423\Nette\Caching\Storages;

use RectorPrefix20210423\Nette;
use RectorPrefix20210423\Nette\Caching\Cache;
/**
 * SQLite storage.
 */
class SQLiteStorage implements \RectorPrefix20210423\Nette\Caching\Storage, \RectorPrefix20210423\Nette\Caching\BulkReader
{
    use Nette\SmartObject;
    /** @var \PDO */
    private $pdo;
    public function __construct(string $path)
    {
        if ($path !== ':memory:' && !\is_file($path)) {
            \touch($path);
            // ensures ordinary file permissions
        }
        $this->pdo = new \PDO('sqlite:' . $path);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('
			PRAGMA foreign_keys = ON;
			CREATE TABLE IF NOT EXISTS cache (
				key BLOB NOT NULL PRIMARY KEY,
				data BLOB NOT NULL,
				expire INTEGER,
				slide INTEGER
			);
			CREATE TABLE IF NOT EXISTS tags (
				key BLOB NOT NULL REFERENCES cache ON DELETE CASCADE,
				tag BLOB NOT NULL
			);
			CREATE INDEX IF NOT EXISTS cache_expire ON cache(expire);
			CREATE INDEX IF NOT EXISTS tags_key ON tags(key);
			CREATE INDEX IF NOT EXISTS tags_tag ON tags(tag);
			PRAGMA synchronous = OFF;
		');
    }
    /**
     * @param string $key
     */
    public function read($key)
    {
        $stmt = $this->pdo->prepare('SELECT data, slide FROM cache WHERE key=? AND (expire IS NULL OR expire >= ?)');
        $stmt->execute([$key, \time()]);
        if (!($row = $stmt->fetch(\PDO::FETCH_ASSOC))) {
            return;
        }
        if ($row['slide'] !== null) {
            $this->pdo->prepare('UPDATE cache SET expire = ? + slide WHERE key=?')->execute([\time(), $key]);
        }
        return \unserialize($row['data']);
    }
    /**
     * @param mixed[] $keys
     */
    public function bulkRead($keys) : array
    {
        $stmt = $this->pdo->prepare('SELECT key, data, slide FROM cache WHERE key IN (?' . \str_repeat(',?', \count($keys) - 1) . ') AND (expire IS NULL OR expire >= ?)');
        $stmt->execute(\array_merge($keys, [\time()]));
        $result = [];
        $updateSlide = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            if ($row['slide'] !== null) {
                $updateSlide[] = $row['key'];
            }
            $result[$row['key']] = \unserialize($row['data']);
        }
        if (!empty($updateSlide)) {
            $stmt = $this->pdo->prepare('UPDATE cache SET expire = ? + slide WHERE key IN(?' . \str_repeat(',?', \count($updateSlide) - 1) . ')');
            $stmt->execute(\array_merge([\time()], $updateSlide));
        }
        return $result;
    }
    /**
     * @param string $key
     * @return void
     */
    public function lock($key)
    {
    }
    /**
     * @param string $key
     * @param mixed[] $dependencies
     * @return void
     */
    public function write($key, $data, $dependencies)
    {
        $expire = isset($dependencies[\RectorPrefix20210423\Nette\Caching\Cache::EXPIRATION]) ? $dependencies[\RectorPrefix20210423\Nette\Caching\Cache::EXPIRATION] + \time() : null;
        $slide = isset($dependencies[\RectorPrefix20210423\Nette\Caching\Cache::SLIDING]) ? $dependencies[\RectorPrefix20210423\Nette\Caching\Cache::EXPIRATION] : null;
        $this->pdo->exec('BEGIN TRANSACTION');
        $this->pdo->prepare('REPLACE INTO cache (key, data, expire, slide) VALUES (?, ?, ?, ?)')->execute([$key, \serialize($data), $expire, $slide]);
        if (!empty($dependencies[\RectorPrefix20210423\Nette\Caching\Cache::TAGS])) {
            foreach ($dependencies[\RectorPrefix20210423\Nette\Caching\Cache::TAGS] as $tag) {
                $arr[] = $key;
                $arr[] = $tag;
            }
            $this->pdo->prepare('INSERT INTO tags (key, tag) SELECT ?, ?' . \str_repeat('UNION SELECT ?, ?', \count($arr) / 2 - 1))->execute($arr);
        }
        $this->pdo->exec('COMMIT');
    }
    /**
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        $this->pdo->prepare('DELETE FROM cache WHERE key=?')->execute([$key]);
    }
    /**
     * @param mixed[] $conditions
     * @return void
     */
    public function clean($conditions)
    {
        if (!empty($conditions[\RectorPrefix20210423\Nette\Caching\Cache::ALL])) {
            $this->pdo->prepare('DELETE FROM cache')->execute();
        } else {
            $sql = 'DELETE FROM cache WHERE expire < ?';
            $args = [\time()];
            if (!empty($conditions[\RectorPrefix20210423\Nette\Caching\Cache::TAGS])) {
                $tags = $conditions[\RectorPrefix20210423\Nette\Caching\Cache::TAGS];
                $sql .= ' OR key IN (SELECT key FROM tags WHERE tag IN (?' . \str_repeat(',?', \count($tags) - 1) . '))';
                $args = \array_merge($args, $tags);
            }
            $this->pdo->prepare($sql)->execute($args);
        }
    }
}
