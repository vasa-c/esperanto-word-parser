<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Result of a word parsing
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Result
{
    public $root;

    public $prefix;

    public $suffixes = [];

    public $part;

    public $accus = false;

    public $plural = false;

    /**
     * Representation
     *
     * @param string $sep
     * @return string
     */
    public function repr($sep = '-')
    {
        $r = [];
        if ($this->prefix !== null) {
            $r[] = $this->prefix;
        }
        $r[] = $this->root;
        $r = \array_merge($r, $this->suffixes);
        if ($this->part !== null) {
            $r[] = $this->part;
        }
        if ($this->plural) {
            $r[] = 'j';
        }
        if ($this->accus) {
            $r[] = 'n';
        }
        return \implode($sep, $r);
    }
}
