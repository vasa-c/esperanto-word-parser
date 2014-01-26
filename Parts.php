<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Definition of parts of speech
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Parts
{
    /**
     * Define part of speech
     *
     * @param string $word
     * @return object
     *         [remain, part, accus, plural]
     */
    public static function define($word, $ap = false)
    {
        $result = (object)[
            'remain' => $word,
            'part' => null,
        ];
        $pattern = '^(.+?)(o|a|e|i|is|as|os|us|u)';
        if ($ap) {
            $result->accus = false;
            $result->plural = false;
            $pattern .= '(n|j|nj|jn)?';
        }
        $pattern = '/'.$pattern.'$/is';
        if (!\preg_match($pattern, $word, $matches)) {
            return $result;
        }
        $result->remain = $matches[1];
        $result->part = $matches[2];
        if (isset($matches[3])) {
            switch ($matches[3]) {
                case 'n':
                    $result->accus = true;
                    break;
                case 'j':
                    $result->plural = true;
                    break;
                case 'nj':
                case 'jn':
                    $result->accus = true;
                    $result->plural = true;
                    break;
            }
        }
        return $result;
    }
}
