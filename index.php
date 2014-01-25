<?php
/**
 * Esperanto word parser
 *
 * @package go\ewp
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @uses PHP5.4+
 */

namespace go\ewp;

if (!\is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: ./composer.phar install --dev');
}

require_once(__DIR__.'/vendor/autoload.php');
