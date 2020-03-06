<?php

namespace Developergf\Excel\Concerns;

interface WithBatchInserts
{
    /**
     * @return int
     */
    public function batchSize(): int;
}
