<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

use InvalidArgumentException;

/**
 * Utility class with static methods.
 */
class Utils
{
    /**
     * Convert the given number of milliseconds into a human-readable string
     * following the format "hh:mm:ss.sss" (when the number of hours is greater
     * than zero) or "mm:ss.sss" (when the number of hours is zero).
     *
     * @param int $ms The number of milliseconds to convert.
     * @return string
     */
    public static function millisecondsToDisplayTime(int $ms): string
    {
        $h = $m = $s = 0;

        $h = floor($ms / 3600000);
        $m = floor(($ms % 3600000) / 60000);
        $s = ($ms % 60000) / 1000;

        if ($h > 0) {
            return sprintf("%02d:%02d:%06.3f", $h, $m, $s);
        }
        return sprintf("%02d:%06.3f", $m, $s);
    }

    /**
     * Return all possible permutations of `$items` in groups of `$length`
     * items, where repeated elements are allowed.
     *
     * E.g., if `$items` = `['a', 'b']` and `$length` = `3` this function will
     * return an array of `count($items) ^ count($length)` items, such as:
     *
     * ```
     * ['a', 'a', 'a']
     * ['a', 'a', 'b']
     * ['a', 'b', 'a']
     * (...)
     * ['b', 'b', 'a']
     * ['b', 'b', 'b']
     * ```
     *
     * @param array $items The set of items to permutate.
     * @param int $length The length of the permutated sets.
     * @return array An array of `$items ^ $length` elements with all possible
     * permutations.
     * @throws \InvalidArgumentException If `$length` is negative.
     */
    public static function getPermutationsWithRepetition(array $items, int $length): array
    {
        if ($length < 0) {
            throw new InvalidArgumentException("Length cannot be negative");
        }

        if ($length === 1) {
            return array_map(fn ($i) => [$i], $items);
        }

        if ($length === 0) {
            return [];
        }

        $permutationsOfNMinusOne = static::getPermutationsWithRepetition($items, $length - 1);

        $permutations = [];
        foreach ($items as $item) {
            foreach ($permutationsOfNMinusOne as $comb) {
                $permutations[] = array_merge([$item], $comb);
            }
        }

        return $permutations;
    }

    /**
     * Return all possible combinations of `$items` in groups of `$length`
     * items, where repeated elements are not allowed.
     *
     * E.g., if `$items`= `['a', 'b', 'c', 'd', 'e']` and `$length` = `2` this
     * function will return an array of `binomial_coefficient($items, $length)`
     * items, such as:
     *
     * ```
     * ['a', 'b']
     * ['a', 'c']
     * ['a', 'd']
     * ['a', 'e']
     * ['b', 'c']
     * ['b', 'd']
     * ['b', 'e']
     * ['c', 'd']
     * ['c', 'e']
     * ['d', 'e']
     * ```
     *
     * Note that this method does not sort results.
     *
     * @param array $items The set of elements to combine.
     * @param int $length The length of the combined sets.
     * @return array An array of `binomial_coefficient($items, $length)`
     * elements with all possible permutations.
     * @throws \InvalidArgumentException If `$length` is negative.
     */
    public static function getCombinationsWithoutRepetition(array $items, int $length): array
    {
        if ($length < 0) {
            throw new InvalidArgumentException("Length cannot be negative");
        }

        if ($length === 1) {
            return array_map(fn ($i) => [$i], $items);
        }

        if ($length === 0 || empty($items)) {
            return [];
        }

        $combinations = [];

        // The following would also work:
        //      while (($retrieved = array_pop($items)) !== null) {
        // But elements are taken off the end of the array, so the end result
        // is a bit less intuitive to understand when printed.
        while (($retrieved = array_splice($items, 0, 1)[0]) && count($items)) {
            $x = static::getCombinationsWithoutRepetition($items, $length - 1);
            foreach ($x as $xx) {
                $combinations[] = array_merge([$retrieved], $xx);
            }
        }

        return $combinations;
    }
}
