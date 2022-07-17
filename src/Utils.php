<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

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
}
