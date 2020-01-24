<?php

namespace AdrianoFerreira\DS\HashTable;

class Node
{

    private $value;
    private $key;
    private $next;

    public function __construct( $key, $value )
    {
        $this->value = $value;
        $this->key = $key;
    }

    public function getNext() {
        return $this->next;
    }

    public function setNext( Node $node ) {
        $this->next = $node;
    }

    public function setValue( $value )
    {
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}