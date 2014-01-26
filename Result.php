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

    public $prefixes = [];

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
        $r = $this->prefixes;
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

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $r = '';
        foreach ($this->prefixes as $prefix) {
            $r .= '('.$prefix.')';
        }
        $r .= $this->root;
        foreach ($this->suffixes as $suffix) {
            $r .= '<'.$suffix.'>';
        }
        if ($this->part) {
            $r .= '['.$this->part.']';
        }
        $end = '';
        if ($this->plural) {
            $end .= 'j';
        }
        if ($this->accus) {
            $end .= 'n';
        }
        if ($end !== '') {
            $r .= '('.$end.')';
        }
        return $r;
    }
}
