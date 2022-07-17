<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

/**
 * A type of tyre, including attributes that determine its performance
 * characteristics.
 */
class TyreType
{
    /**
     * Create a new TyreType.
     *
     * @param string $name The name of the tyre type.
     * @param int $deltaOverOptimalLapTime The amount of time that this tyre
     * adds, as a minimum, to the optimal lap time, in milliseconds.
     * @param int $degradationFactor An integer describing how much lap times
     * are affected by the degradation suffered by this tyre. Right now it is
     * calculated such that a factor of 1 = 0.1% increase in lap time per lap.
     */
    public function __construct(
        public string $name,
        public int $deltaOverOptimalLapTime,
        public int $degradationFactor,
    ) {}
}
