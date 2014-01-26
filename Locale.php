<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * The locale
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Locale
{
    /**
     * Constructor
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return \go\ewp\Dict
     */
    public function getDict()
    {
        if (!$this->dict) {
            $this->dict = Dict::loadFromFile($this->dir.'/roots.txt');
        }
        return $this->dict;
    }

    /**
     * @return \go\ewp\Phonetics
     */
    public function getPhonetics()
    {
        if (!$this->phonetics) {
            $this->phonetics = new Phonetics($this->dir.'/phonetics.txt');
        }
        return $this->phonetics;
    }

    /**
     * @var string
     */
    private $dir;

    /**
     * @var \go\ewp\Dict
     */
    private $dict;

    /**
     * @var \go\ewp\Phonetics
     */
    private $phonetics;
}