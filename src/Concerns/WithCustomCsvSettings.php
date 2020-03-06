<?php

namespace Developergf\Excel\Concerns;

interface WithCustomCsvSettings
{
    /**
     * @return array
     */
    public function getCsvSettings(): array;
}
