<?php

namespace Chiron\Support;

use InvalidArgumentException;

final class Str
{
    /**
     * Starts the $haystack string with the prefix $needle?
     */
    // TODO : créer une classe Str ou Strings dans le package chiron/support pour déplacer et mutualiser cette méthode ????
    public static function startsWith(string $haystack, string $needle): bool
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }


    /**
     * Ends the $haystack string with the suffix $needle?
     */
    // TODO : créer une classe Str ou Strings dans le package chiron/support pour déplacer et mutualiser cette méthode ????
    public static function endsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || substr($haystack, -strlen($needle)) === $needle;
    }
}
