<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Convert diacritic to plain latin and vice versa
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Diacritic
{
    /**
     * @param string $text
     * @return string
     */
    public static function diacritic2latin($text)
    {
        return \strtolower(\str_replace(self::$rds, self::$rdr, $text));
    }

    /**
     * @param string $text
     * @return string
     */
    public static function latin2diacritic($text)
    {
        return \str_replace(self::$rls, self::$rlr, $text);
    }

    private static $rds = ['Ĉ', 'Ĝ', 'Ĥ', 'Ĵ', 'Ŝ', 'Ŭ', 'ĉ', 'ĝ', 'ĥ', 'ĵ', 'ŝ', 'ŭ'];

    private static $rdr = ['cx', 'gx', 'hx', 'jx', 'sx', 'ux', 'cx', 'gx', 'hx', 'jx', 'sx', 'ux'];

    private static $rls = ['cx', 'gx', 'hx', 'jx', 'sx', 'ux', 'u~'];

    private static $rlr = ['ĉ', 'ĝ', 'ĥ', 'ĵ', 'ŝ', 'ŭ', 'ŭ'];
}
