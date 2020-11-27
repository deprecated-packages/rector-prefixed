<?php

namespace _PhpScoperbd5d0c5f7638;

class OCICollection
{
    /**
     * @alias oci_free_collection
     * @return bool
     */
    public function free()
    {
    }
    /**
     * @alias oci_collection_append
     * @return bool
     */
    public function append(string $value)
    {
    }
    /**
     * @alias oci_collection_element_get
     * @return string|float|null|false
     */
    public function getElem(int $index)
    {
    }
    /**
     * @alias oci_collection_assign
     * @return bool
     */
    public function assign(\_PhpScoperbd5d0c5f7638\OCICollection $from)
    {
    }
    /**
     * @alias oci_collection_element_assign
     * @return bool
     */
    public function assignelem(int $index, string $value)
    {
    }
    /**
     * @alias oci_collection_size
     * @return int|false
     */
    public function size()
    {
    }
    /**
     * @alias oci_collection_max
     * @return int|false
     */
    public function max()
    {
    }
    /**
     * @alias oci_collection_trim
     * @return bool
     */
    public function trim(int $num)
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\OCICollection', 'OCICollection', \false);
