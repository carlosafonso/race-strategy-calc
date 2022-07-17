<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

/**
 * A race strategy.
 */
class Strategy
{
    /**
     * @var Afonso\Pitstops\Stint[]
     */
    protected array $stints = [];

    /**
     * Create a new Strategy configured with the provided parameters.
     *
     * @param int $laps The number of laps in the race.
     * @param int $optimalLapTime The absolute best lap time that can be
     * achieved in the race, in milliseconds.
     * @param int $pitstopDelay The extra time added to a lap due to pitstops,
     * in milliseconds.
     */
    public function __construct(
        protected int $laps,
        protected int $optimalLapTime,
        protected int $pitstopDelay,
    ) { }

    /**
     * Add a new stint to the strategy.
     *
     * Stints are considered in the order they are added to this strategy.
     *
     * @param Afonso\Pitstops\Stint $stint The stint to add to this strategy.
     */
    public function addStint(Stint $stint): void
    {
        $this->stints[] = $stint;
        usort(
            $this->stints,
            function (Stint $a, Stint $b) {
                return $a->startLap <=> $b->startLap;
            }
        );
    }

    /**
     * Simulate the given strategy and return its results.
     *
     * @return Afonso\Pitstops\SimulationResult
     */
    public function simulate(): SimulationResult
    {
        $result = new SimulationResult();

        $currentStint = 0;
        for ($lap = 1; $lap <= $this->laps; $lap++) {
            $pittedInLap = false;

            // If there are more stints after the current one, check if the
            // current lap belongs to the next stint and change stints if so.
            if (count($this->stints) - 1 > $currentStint && $this->stints[$currentStint + 1]->startLap === $lap) {
                $currentStint++;
                $pittedInLap = true;
            }

            $lapNumberInStint = $lap - $this->stints[$currentStint]->startLap + 1;
            $lapTime = ($this->optimalLapTime + $this->stints[$currentStint]->tyreType->deltaOverOptimalLapTime)
                * pow(1 + $this->stints[$currentStint]->tyreType->degradationFactor / 1000, $lapNumberInStint - 1)
                + ($pittedInLap ? $this->pitstopDelay : 0);

            $result->addLap(
                $lap,
                (int) $lapTime,
                $this->stints[$currentStint]->tyreType->name
            );
        }

        return $result;
    }
}
