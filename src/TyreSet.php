<?php
declare(strict_types=1);

namespace Afonso\Pitstops;

/**
 * A set of tyres, used by a car during a stint.
 */
class TyreSet
{
    /**
     * Create a new TyreSet.
     *
     * @param Afonso\Pitstops\TyreType $type The type of this tyre set.
     */
    public function __construct(
        public TyreType $type,
    ) {}
}
