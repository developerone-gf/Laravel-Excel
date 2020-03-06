<?php

namespace Developergf\Excel\Concerns;

interface WithCustomChunkSize
{
    /**
     * @return int
     */
    public function chunkSize(): int;
}
