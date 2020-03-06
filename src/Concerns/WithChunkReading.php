<?php

namespace Developergf\Excel\Concerns;

interface WithChunkReading
{
    /**
     * @return int
     */
    public function chunkSize(): int;
}
