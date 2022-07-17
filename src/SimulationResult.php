<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

/**
 * The result of a strategy simulation, which includes the calculated lap
 * times.
 */
class SimulationResult
{
    /**
     * @var \Afonso\Pitstops\SimulatedLap[];
     */
    public array $laps = [];

    /**
     * Add a new lap to these results.
     *
     * @param int $lapNumber The lap number.
     * @param int $lapTime The time it takes to complete the lap, in
     * milliseconds.
     * @param string $tyreTypeName The name of the type of tyre used in this
     * lap.
     */
    public function addLap(int $lapNumber, int $lapTime, string $tyreTypeName): void
    {
        $this->laps[] = new SimulatedLap($lapNumber, $lapTime, $tyreTypeName);
    }
}
