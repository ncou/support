<?php

namespace Chiron\Support;

use InvalidArgumentException;

//https://github.com/top-think/think-helper/blob/3.0/src/helper/Str.php
//https://github.com/nette/utils/blob/master/src/Utils/Strings.php
//https://github.com/illuminate/support/blob/master/Str.php
//https://github.com/fuelphp/common/blob/master/src/Str.php

// TODO : permettre de chainer les interactions : ex : Str::of('my_string')->explode('\n')->filter()->each($callable)
// https://github.com/illuminate/support/blob/master/Stringable.php
// https://github.com/illuminate/support/blob/master/Str.php#L53

final class Str
{
    /**
     * Starts the $haystack string with the prefix $needle?
     */
    // TODO : enlever cette méthode et utiliser directement dans le code la méthode native php8 !!!
    public static function startsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }

    /**
     * Ends the $haystack string with the suffix $needle?
     */
    // TODO : enlever cette méthode et utiliser directement dans le code la méthode native php8 !!!
    public static function endsWith(string $haystack, string $needle): bool
    {
        return str_ends_with($haystack, $needle);
    }

    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    // TODO : renommer $subject en $haystack et $search par $needle ???
    public static function before(string $subject, string $search): string
    {
        if ($search === '') {
            return $subject;
        }

        $result = strstr($subject, $search, true);

        return $result === false ? $subject : $result;
    }

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    // TODO : renommer $subject en $haystack et $search par $needle ???
    public static function after(string $subject, string $search): string
    {
        // TODO - Autre exemple : https://github.com/nette/utils/blob/a828903f85bb513e51ba664b44b61f20d812cf20/src/Utils/Strings.php#L434
        return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
    }

    /**
     * Returns the portion of the string specified by the start and length parameters.
     *
     * @param  string  $string
     * @param  int  $start
     * @param  int|null  $length
     * @return string
     */
    public static function substr(string $string, int $start, ?int $length = null): string
    {
        // TODO : il faut ajouter dans le fichier composer que l'extension mb_string est obligatoire !!!!
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @param  bool  $ignoreCase
     * @return bool
     */
    // TODO : utiliser plutot cette méthode, voir même la méthode native de php8 ????  https://github.com/nette/utils/blob/a828903f85bb513e51ba664b44b61f20d812cf20/src/Utils/Strings.php#L97
    public static function contains($haystack, $needles, $ignoreCase = false)
    {
        if ($ignoreCase) {
            $haystack = mb_strtolower($haystack);
            $needles = array_map('mb_strtolower', (array) $needles);
        }

        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
