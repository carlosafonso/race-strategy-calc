<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

/**
 * A race stint, which includes the lap at which the stint begins as well as
 * the set of types used throughout it.
 */
class Stint
{
    /**
     * Create a new Stint.
     *
     * @param int $startLap The lap at which this stint begins.
     * @param Afonso\Pitstops\TyreSet $tyreSet The set of tyres used in this
     * stint.
     */
    public function __construct(
        public int $startLap,
        public TyreSet $tyreSet,
    ) {}
}
