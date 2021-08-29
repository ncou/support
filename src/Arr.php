<?php

namespace Chiron\Support;

use InvalidArgumentException;

//https://github.com/top-think/think-helper/blob/3.0/src/helper/Arr.php
//https://github.com/illuminate/collections/blob/master/Arr.php
//https://github.com/nette/utils/blob/master/src/Utils/Arrays.php
//https://github.com/fuelphp/common/blob/master/src/Arr.php

final class Arr
{
    /**
     * Get one or a specified number of random values from an array.
     *
     * @param array    $array
     * @param int|null $number
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function random(array $array,?int $number = null)
    {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            throw new InvalidArgumentException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }

        if ((int) $number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array) $keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }
}
