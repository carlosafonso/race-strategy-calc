<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

use Afonso\Pitstops\TyreType as TyreType;

/**
 * A race stint, which includes the lap at which the stint begins as well as
 * the type of tyre used throughout it.
 */
class Stint
{
    /**
     * Create a new Stint.
     *
     * @param int $startLap The lap at which this stint begins.
     * @param Afonso\Pitstops\TyreType $tyreType The type of tyre used in this
     * stint.
     */
    public function __construct(
        public int $startLap,
        public TyreType $tyreType
    ) {}
}
