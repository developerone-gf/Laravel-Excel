<?php

namespace Periplia\Sheet\Excel\Concerns;

use Periplia\Sheet\Excel\Validators\Failure;

interface SkipsOnFailure
{
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures);
}
