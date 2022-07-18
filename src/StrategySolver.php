<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

/**
 * A solver that attempts to find the best possible strategy for a given set of
 * constraints.
 */
class StrategySolver
{
    protected ?LoggerInterface $log;

    /**
     * Create a new StrategySolver.
     *
     * @param \Psr\Log\LoggerInterface $logger The logger to be used by this
     * class.
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        if ($logger === null) {
            $this->log = new Logger(__CLASS__);
            $this->log->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
        } else {
            $this->log = $logger;
        }
    }

    /**
     * Find the best possible race strategy that fulfills the specified
     * criteria.
     *
     * @param int $laps The number of laps in the race.
     * @param int $optimalLapTime The absolute best lap time that can be
     * achieved in the race, in milliseconds.
     * @param int $pitstopDelay The extra time added to a lap due to pitstops,
     * in milliseconds.
     * @param \Afonso\Pitstops\TyreSet[] $tyreSets The sets of tyres available
     * in the race.
     * @param int $maxStops The maximum number of pit stops to consider in the
     * strategy.
     * @return \Afonso\Pitstops\Strategy The best strategy found by the solver.
     */
    public function findBestStrategy(
        int $laps,
        int $optimalLapTime,
        int $pitstopDelay,
        array $tyreSets,
        int $maxStops,
    ): Strategy {
        /**
         * @var \Afonso\Pitstops\Strategy
         */
        $bestStrategy = null;

        /**
         * @var \Afonso\Pitstops\SimulationResult
         */
        $bestResult = null;

        // We evaluate strategies from one stop up to the maximum specified.
        for ($nStops = 1; $nStops <= $maxStops; $nStops++) {
            // This contains all the possible combinations of tyre sets that we
            // will evaluate. All combinations have the same number of items,
            // which corresponds with the number of stops plus one (or, to put
            // in another way, as many sets as stints).
            $tyreSetSequences = Utils::getPermutationsWithRepetition($tyreSets, $nStops + 1);

            // The first stint always begins at lap 1. For the rest of stints
            // we'll run over all possible combinations of pit laps (e.g., for
            // a 2-stop strategy we'll evaluate stints starting at laps [1, 2,
            // 3], [1, 2, 4], [1, 3, 4], ...).
            $stintStartLapOptions = array_map(
                function ($stintStartLaps) {
                    return array_merge([1], $stintStartLaps);
                },
                Utils::getCombinationsWithoutRepetition(range(2, $laps - 1), $nStops)
            );

            foreach ($stintStartLapOptions as $stintStartLaps) {
                foreach ($tyreSetSequences as $tyreSetSequence) {
                    $this->log->debug(
                        "Testing",
                        ['stintStartLaps' => $stintStartLaps, 'tyreSetSequence' => $tyreSetSequence]
                    );

                    $strategy = new Strategy($laps, $optimalLapTime, $pitstopDelay);

                    foreach ($tyreSetSequence as $idx => $tyreSet) {
                        $strategy->addStint(new Stint($stintStartLaps[$idx], $tyreSet));
                    }

                    $result = $strategy->simulate();
                    if ($bestResult === null || $bestResult->getTotalRaceTime() > $result->getTotalRaceTime()) {
                        $this->log->info(
                            "Found a better strategy",
                            [
                                'stintStartLaps' => $stintStartLaps,
                                'tyreSetSequence' => $tyreSetSequence,
                                'previousBest' => $bestResult?->getTotalRaceTime(),
                                'newBest' => $result->getTotalRaceTime(),
                            ]
                        );
                        $bestResult = $result;
                        $bestStrategy = $strategy;
                    }
                }
            }
        }

        return $bestStrategy;
    }
}
