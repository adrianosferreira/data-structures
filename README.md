# Data Structures Library for PHP

[![Build Status](https://travis-ci.org/adrianosferreira/data-structures.svg?branch=master)](https://travis-ci.org/adrianosferreira/data-structures)
[![Build Status](https://codecov.io/gh/adrianosferreira/data-structures/branch/master/graph/badge.svg)](https://codecov.io/gh/adrianosferreira/data-structures)
[![Total Downloads](https://poser.pugx.org/adrianoferreira/data-structures/downloads)](https://packagist.org/packages/adrianoferreira/data-structures)
[![License](https://poser.pugx.org/adrianoferreira/data-structures/license)](https://packagist.org/packages/adrianoferreira/data-structures)

A set of data structures implemented in PHP:

- Hash Table
- More soon...

## Installation

It's recommended that you use Composer to install this library.

```
$ composer require adrianoferreira/data-structures:dev-master
```

## Usage

```php
$hashTable = new \AdrianoFerreira\DS\HashTable\Table( 10 );
$hashTable->insert( 'my-key', 'my value' );
$hashTable->insert( 'my-key', 'updated value' );
$hashTable->insert( 'other-key', 'other value' );
$hashTable->insert( 'abc', 'abc value' );
$hashTable->insert( 'cba', 'cba value' );

//Outputs 'updated value' as it replaces the value of buckets with same key
echo $hashTable->get('my-key');

//Outputs 'other value'
echo $hashTable->get('other-key');

//Outputs 'cba value'
echo $hashTable->get('cba');
```