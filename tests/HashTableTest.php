<?php

namespace AdrianoFerreira\DS\HashTable;

use PHPUnit\Framework\TestCase;

class HashTableTest extends TestCase
{

    /**
     * @param $size
     *
     * @dataProvider dpDataInsertion
     */
    public function testDataInsertionDistinctKeys($size, $items)
    {
        $hashTable = new Table($size);

        $this->assertCount($size, $hashTable->getBuckets());

        foreach ($items as $item) {
            $hashTable->insert($item['key'], $item['value']);
        }

        foreach ($items as $item) {
            $this->assertEquals($item['value'], $hashTable->get($item['key']));
        }
    }

    public function dpDataInsertion()
    {
        return [
            [
                10,
                [
                    ['key' => 'some key', 'value' => 'some value'],
                ]
            ],
            [
                20,
                [
                    ['key' => 'some$%TDAFDkey', 'value' => 'New value'],
                ]
            ],
            [
                50,
                [
                    ['key' => 123, 'value' => 'My value'],
                ]
            ],
        ];
    }

    /**
     * @param $size
     *
     * @dataProvider dpDataInsertionWithKeysCollision
     */
    public function testDataInsertionWithKeysCollision(
        $size,
        $items,
        $key,
        $expect
    ) {
        $hashTable = new Table($size);

        $this->assertCount($size, $hashTable->getBuckets());

        foreach ($items as $item) {
            $hashTable->insert($item['key'], $item['value']);
        }

        $this->assertEquals($expect, $hashTable->get($key));
    }

    public function dpDataInsertionWithKeysCollision()
    {
        return [
            [
                10,
                [
                    ['key' => 'somekey', 'value' => 'first'],
                    ['key' => 'somekey', 'value' => 'second'],
                    ['key' => 'somekey', 'value' => 'third'],
                ],
                'somekey',
                'third'
            ],
            [
                20,
                [
                    ['key' => 10, 'value' => 'first'],
                    ['key' => 10, 'value' => 'second'],
                    ['key' => 10, 'value' => 'third'],
                ],
                10,
                'third'
            ],
        ];
    }

    /**
     * @param $size
     *
     * @dataProvider dpDataInsertionMixingCollisionWithSingleBucket
     */
    public function testDataInsertionMixingCollisionWithSingleBucket(
        $size,
        $items,
        $key,
        $expect
    ) {
        $hashTable = new Table($size);

        $this->assertCount($size, $hashTable->getBuckets());

        foreach ($items as $item) {
            $hashTable->insert($item['key'], $item['value']);
        }

        $this->assertEquals($expect, $hashTable->get($key));
    }

    public function testGetReturnsNullWhenNoBucketIsFound()
    {
        $hashTable = new Table(10);
        $hashTable->insert('123', 456);
        $hashTable->insert('key', 'value');

        $this->assertNull($hashTable->get('not existing'));
    }

    public function dpDataInsertionMixingCollisionWithSingleBucket()
    {
        return [
            [
                10,
                [
                    ['key' => 'somekey', 'value' => 'first'],
                    ['key' => 'somekey', 'value' => 'second'],
                    ['key' => 'somekey', 'value' => 'third'],
                    ['key' => 'test', 'value' => 'testValue'],
                ],
                'test',
                'testValue'
            ],
            [
                10,
                [
                    ['key' => 'somekey', 'value' => 'first'],
                    ['key' => 'somekey', 'value' => 'second'],
                    ['key' => 'somekey', 'value' => 'third'],
                    ['key' => 'test', 'value' => 'testValue'],
                    ['key' => 123, 'value' => '456'],
                ],
                '123',
                '456'
            ],
            [
                10,
                [
                    ['key' => 'somekey', 'value' => 'first'],
                    ['key' => 'somekey', 'value' => 'second'],
                    ['key' => 'somekey', 'value' => 'third'],
                    ['key' => 'test', 'value' => 'testValue'],
                    ['key' => 123, 'value' => '456'],
                ],
                'somekey',
                'third'
            ],
            [
                10,
                [
                    ['key' => 'abc', 'value' => 'first'],
                    ['key' => 'cba', 'value' => 'cba value'],
                    ['key' => 'somekey', 'value' => 'third'],
                    ['key' => 'test', 'value' => 'testValue'],
                    ['key' => 123, 'value' => '456'],
                ],
                'cba',
                'cba value'
            ],
        ];
    }
}