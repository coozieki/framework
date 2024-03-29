<?php

namespace tests\Unit\Support;

use Coozieki\Framework\Support\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @covers \Coozieki\Framework\Support\Collection::all
     */
    public function testAll(): void
    {
        $array = [1, 2, 3];
        $collection = new Collection($array);

        $this->assertEquals($array, $collection->all());
    }

    /**
     * @covers \Coozieki\Framework\Support\Collection::push
     * @covers \Coozieki\Framework\Support\Collection::all
     */
    public function testPush(): void
    {
        $initialArray = [
            [
                'field' => 5
            ],
            [
                'field' => 4
            ]
        ];

        $collection = new Collection($initialArray);
        $collection->push(['field' => 6]);

        $this->assertEquals([
            [
                'field' => 5
            ],
            [
                'field' => 4
            ],
            [
                'field' => 6
            ]
        ], $collection->all());
    }

    /**
     * @covers \Coozieki\Framework\Support\Collection::fromArray
     * @covers \Coozieki\Framework\Support\Collection::all
     */
    public function testFromArray(): void
    {
        $array = [3, 2, 1];
        $collection = Collection::fromArray($array);

        $this->assertEquals($array, $collection->all());
    }
}