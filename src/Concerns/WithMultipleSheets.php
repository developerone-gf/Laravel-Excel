<?php

namespace Developergf\Excel\Concerns;

interface WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array;
}
