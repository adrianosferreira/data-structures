<?php

namespace AdrianoFerreira\DS\HashTable;

class Table
{

    private $buckets;
    private $numBuckets;

    public function __construct($size)
    {
        if ( ! is_int($size)) {
            throw new \InvalidArgumentException(sprintf('The value of $size should be an integer, %s given',
                $size));
        }

        $this->numBuckets = $size;
        $this->buckets    = new \SplFixedArray($size);
    }

    public function insert($key, $value)
    {
        $key     = $this->normalizeKey($key);
        $hash    = $this->hash($key);
        $newNode = new Node($key, $value);

        if ( ! isset($this->buckets[$hash])) {
            $this->buckets[$hash] = $newNode;
        } else {
            $this->insertHelper($newNode, $this->buckets[$hash]);
        }
    }

    public function get($key)
    {
        $key  = $this->normalizeKey($key);
        $hash = $this->hash($key);
        if ( ! isset($this->buckets[$hash])) {
            return null;
        }

        return $this->getHelper($key, $this->buckets[$hash]);
    }

    private function getHelper($key, Node $current)
    {
        if ($current->getKey() === $key) {
            return $current->getValue();
        } elseif ($current->getNext()) {
            return $this->getHelper($key, $current->getNext());
        } else {
            return null;
        }
    }

    private function insertHelper(Node $newNode, Node $current)
    {
        if ($current->getKey() === $newNode->getKey()) {
            $current->setValue($newNode->getValue());
        } elseif ( ! $current->getNext()) {
            $current->setNext($newNode);
        } else {
            $this->insertHelper($newNode, $current->getNext());
        }
    }

    private function hash($key)
    {
        $total = 0;
        $key   = (string)$key;
        for ($i = 0; $i < strlen($key); $i++) {
            $total += ord($key[$i]);
        }

        return $total % $this->numBuckets;
    }

    public function getBuckets()
    {
        return $this->buckets;
    }

    private function normalizeKey($key)
    {
        return (string)$key;
    }
}