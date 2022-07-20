<?php

namespace Chiron\Support;

use InvalidArgumentException;

//http://masterminds.github.io/sprig/strings.html

//https://github.com/cakephp/filesystem/blob/master/Filesystem.php
//https://github.com/cakephp/filesystem/blob/master/Folder.php
//https://github.com/cakephp/filesystem/blob/master/File.php

// CAMELIZE
//https://github.com/Sylius/hubkit/blob/master/src/StringUtil.php#L57

// TODO : créer une classe inflector avec des méthodes du genre humanize()
//https://github.com/symfony/symfony/blob/60ce5a3dfbd90fad60cd39fcb3d7bf7888a48659/src/Symfony/Component/Form/FormRenderer.php#L283
//https://book.cakephp.org/4/en/core-libraries/inflector.html#creating-human-readable-forms
//https://github.com/cakephp/cakephp/blob/856741f34393bef25284b86da703e840071c4341/src/Utility/Inflector.php#L427

//https://github.com/top-think/think-helper/blob/3.0/src/helper/Str.php
//https://github.com/nette/utils/blob/master/src/Utils/Strings.php
//https://github.com/illuminate/support/blob/master/Str.php
//https://github.com/fuelphp/common/blob/master/src/Str.php

// TODO : permettre de chainer les interactions : ex : Str::of('my_string')->explode('\n')->filter()->each($callable)
// https://github.com/illuminate/support/blob/master/Stringable.php
// https://github.com/illuminate/support/blob/master/Str.php#L53

//https://github.com/yiisoft/strings/blob/master/src/StringHelper.php

// TODO : attention car le str_start_with est sensible à la casse alors que l'ancienne méthode php7 stripos est sensible à la casse, gérer ce cas ????

final class Str
{
    /**
     * Split lines to an array.
     *
     * @param string $input
     *
     * @return string[]
     */
    public static function splitLines(string $input): array
    {
        $input = trim($input);

        return ($input === '') ? [] : preg_split('{\r?\n}', $input);
    }

    /**
     * Get string length.
     *
     * @param string $string String to calculate length for.
     * @param string $encoding The encoding to use, defaults to "UTF-8".
     *
     * @see https://php.net/manual/en/function.mb-strlen.php
     *
     * @return int
     */
    public static function length(string $string, string $encoding = 'UTF-8'): int
    {
        return mb_strlen($string, $encoding);
    }

    /**
     * Returns the number of bytes in the given string.
     * This method ensures the string is treated as a byte array even if `mbstring.func_overload` is turned on
     * by using {@see mb_strlen()}.
     *
     * @param string $input The string being measured for length.
     *
     * @return int The number of bytes in the given string.
     */
    public static function byteLength(string $input): int
    {
        return mb_strlen($input, '8bit');
    }

    /**
     * Starts the $haystack string with the prefix $needle?
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }

    /**
     * Ends the $haystack string with the suffix $needle?
     */
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
