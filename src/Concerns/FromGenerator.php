<?php

namespace Developergf\Excel\Concerns;

use Generator;

interface FromGenerator
{
    /**
     * @return Generator
     */
    public function generator(): Generator;
}
