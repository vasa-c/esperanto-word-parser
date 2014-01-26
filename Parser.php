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
        if (\in_array($word, $this->eroots)) {
            $result = new Result;
            $result->root = $word;
            return $result;
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
        $r = $dict->getRoot($word);
        if ($r) {
            $result = new Result;
            $result->root = $word;
            return $result;
        }
        $r = $this->checkSuffix($part->remain);
        if ($r) {
            $r->part = $part->part;
            $r->accus = $part->accus;
            $r->plural = $part->plural;
        }
        return $r;
    }

    /**
     * @param string $word
     * @param boolean $epref [optional]
     * @return \go\ewp\Result
     */
    private function checkSuffix($word, $epref = true)
    {
        $suffixes = $this->locale->getSuffixes();
        $suf = $suffixes->find($word);
        if ($suf) {
            if ($this->locale->getDict()->getRoot($suf[0])) {
                $result = new Result();
                $result->root = $suf[0];
            } else {
                $result = $this->checkPrefix($suf[0], true);
            }
            if ($result) {
                $result->suffixes[] = $suf[1];
                return $result;
            }
        }
        if ($epref) {
            return $this->checkPrefix($word, false);
        }
        return null;
    }

    /**
     * @param string $word
     * @param boolean $esuf [optional]
     * @return \go\ewp\Result
     */
    private function checkPrefix($word, $esuf = false)
    {
        $prefixes = $this->locale->getPrefixes();
        $pref = $prefixes->find($word);
        if ($pref) {
            if ($this->locale->getDict()->getRoot($pref[1])) {
                $result = new Result();
                $result->root = $pref[1];
            } else {
                $result = $this->checkPrefix($pref[1], true);
            }
            if ($result) {
                \array_unshift($result->prefixes, $pref[0]);
                return $result;
            }
        }
        if ($esuf) {
            return $this->checkSuffix($word, false);
        }
        return null;
    }

    /**
     * @param string $word
     * @return \go\ewp\Result
     */
    private function rootParse($word)
    {
        if ($this->locale->getDict()->getRoot($word) !== null) {
            $result = new Result;
            $result->root = $word;
            return $result;
        }
        $suffixes = $this->locale->getSuffixes();
        $suf = $suffixes->find($word);
        if ($suf) {
            if (\strlen($suf[0]) > 1) {
                $result = $this->rootParse($suf[0]);
                if ($result !== null) {
                    $result->suffixes[] = $suf[1];
                    return $result;
                }
            }
        }
    }

    /**
     * @var \go\ewp\Locale
     */
    private $locale;

    /**
     * @var array
     */
    private $eroots = ['oni'];
}
