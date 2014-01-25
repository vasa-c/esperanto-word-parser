<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Load a text file to a php array
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class FileLoader
{
    /**
     * Load a file
     *
     * @param string $filename
     * @return array
     */
    public static function load($filename)
    {
        $result = [];
        foreach (\file($filename) as $line) {
            $line = \explode(':', $line, 2);
            if (\count($line) === 2) {
                $result[\trim($line[0])] = \trim($line[1]);
            }
        }
        return $result;
    }
}
