<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\FileLoader;

/**
 * @coversDefaultClass go\ewp\FileLoader
 */
class FileLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::load
     */
    public function testLoad()
    {
        $filename = __DIR__.'/nstst/loadtest.txt';
        $expected = [
            'one' => 'two',
            'three' => 'four',
            'six' => 'seven  : eight',
        ];
        $this->assertSame($expected, FileLoader::load($filename));
    }
}
