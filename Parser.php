<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * The parser of words
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Parser
{
    /**
     * Constructor
     *
     * @param \go\ewp\Locale $locale
     */
    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    /**
     * Parses a word
     *
     * @param string $word
     * @return \go\ewp\Result
     *         an instance of result or NULL
     */
    public function parse($word)
    {
        $len = \strlen($word);
        if ($len < 2) {
            return null;
        }
        if (($len === 2) && ($word[1] === 'x')) {
            return null;
        }
        $dict = $this->locale->getDict();
        $part = Parts::define($word, true);
        if (!\preg_match('/[aioeu]/', $part->remain)) {
            $r = $dict->getRoot($part->remain.$part->part);
            if ($r) {
                $result = new Result;
                $result->root = $part->remain.$part->part;
                $result->accus = $part->accus;
                $result->plural = $part->plural;
                return $result;
            }
            $r = $dict->getRoot($word);
            if ($r) {
                $result = new Result;
                $result->root = $word;
                return $result;
            }
            return null;
        }
        $r = $dict->getRoot($part->remain);
        if ($r) {
            $result = new Result;
            $result->root = $part->remain;
            $result->part = $part->part;
            $result->accus = $part->accus;
            $result->plural = $part->plural;
            return $result;
        }
        return null;
    }

    /**
     * @var \go\ewp\Locale
     */
    private $locale;
}
