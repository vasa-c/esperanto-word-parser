<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Result;

/**
 * @coversDefaultClass go\ewp\Result
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::repr
     */
    public function testRepr()
    {
        $r = new Result();
        $r->root = 'ferm';
        $r->prefix = 'mal';
        $r->suffixes[] = 'igx';
        $r->part = 'is';
        $this->assertSame('mal-ferm-igx-is', $r->repr());
        $this->assertSame('malfermigxis', $r->repr(''));
        $r->accus = true;
        $this->assertSame('malfermigxisn', $r->repr(''));
        $r->plural = true;
        $this->assertSame('mal-ferm-igx-is-j-n', $r->repr());
    }
}
