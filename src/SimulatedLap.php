<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

/**
 * A simulated lap.
 */
class SimulatedLap
{
    /**
     * Create a new SimulatedLap.
     *
     * @param int $lapNumber The lap number.
     * @param int $lapTime The time it takes to complete the lap, in
     * milliseconds.
     * @param string $tyreTypeName The name of the type of tyre used in this
     * lap.
     */
    public function __construct(
        public int $lapNumber,
        public int $lapTime,
        public string $tyreTypeName
    ) {}
}
