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
        $r->prefixes[] = 'mal';
        $r->suffixes[] = 'igx';
        $r->part = 'is';
        $this->assertSame('mal-ferm-igx-is', $r->repr());
        $this->assertSame('malfermigxis', $r->repr(''));
        $r->accus = true;
        $this->assertSame('malfermigxisn', $r->repr(''));
        $r->plural = true;
        $this->assertSame('mal-ferm-igx-is-j-n', $r->repr());
    }

    /**
     * @covers ::__toString
     */
    public function testToString()
    {
        $r = new Result();
        $r->root = 'ferm';
        $r->part = 'is';
        $this->assertSame('ferm[is]', (string)$r);
        $r->prefixes[] = 'mal';
        $this->assertSame('(mal)ferm[is]', (string)$r);
        $r->suffixes[] = 'igx';
        $this->assertSame('(mal)ferm<igx>[is]', (string)$r);
        $r->prefixes[] = 'sen';
        $r->suffixes[] = 'ant';
        $this->assertSame('(mal)(sen)ferm<igx><ant>[is]', (string)$r);
        $r->accus = true;
        $this->assertSame('(mal)(sen)ferm<igx><ant>[is](n)', (string)$r);
        $r->plural = true;
        $this->assertSame('(mal)(sen)ferm<igx><ant>[is](jn)', (string)$r);
    }
}
